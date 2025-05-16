<?php

namespace App\Filament\Pages;

use App\Mail\CustomVerifyEmail;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Concerns;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\Permission\Models\Role;

class EditProfile extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    public ?array $profileData = [];
    public ?array $passwordData = [];

    protected static string $view = 'filament.pages.edit-profile';

    public function getHeading(): string|Htmlable
    {
        return __("filament::resources.user.profile.model_label");
    }

    public function getTitle(): string|Htmlable
    {
        return __("filament::resources.user.profile.model_label");
    }

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Section::make(__('filament::resources.user.profile.form.info_section.heading'))
                        ->description(__('filament::resources.user.profile.form.info_section.description'))
                        ->aside()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(__('filament::resources.user.table.name.label'))
                                ->required(),
                            Forms\Components\TextInput::make('email')
                                ->label(__('filament::resources.user.table.email.label'))
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->suffixIcon(fn ($record) => is_null($record->email_verified_at) ? 'heroicon-m-x-circle' : 'heroicon-m-check-badge')
                                ->suffixIconColor(fn ($record) => is_null($record->email_verified_at) ? 'danger' : 'success'),
                            Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('verify_email')
                                    ->label(__('filament::resources.user.profile.form.info_section.verify_email'))
                                    ->disabled(fn ($record) => !is_null($record->email_verified_at))
                                    ->action(function ($record) {
                                        if (is_null($record->email_verified_at) && $record instanceof Model) {
                                            $user = auth()->user();

                                            $verificationUrl = URL::temporarySignedRoute(
                                                'verification.verify',
                                                Carbon::now()->addMinutes(60),
                                                ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
                                            );

                                            Mail::to($record)->send(new CustomVerifyEmail($user, $verificationUrl));
                                        }
                                        Notification::make()
                                            ->success()
                                            ->title(__('filament::notifications.email_sent'))
                                            ->body(__('filament::notifications.verification_email_sent'))
                                            ->send();
                                    }),
                            ]),
                            Forms\Components\TextInput::make('roles_display')
                                ->label(__('filament::resources.user.table.role.label'))
                                ->afterStateHydrated(fn ($set, $record) => $set('roles_display', Str::ucfirst($record->roles->pluck('name')->join(', '))))
                                ->disabled()
                                ->extraAttributes(['dir' => 'ltr'])
                                ->dehydrated(false),
                            Forms\Components\FileUpload::make('avatar')
                                ->label(__('filament::resources.user.table.avatar.label'))
                                ->required(fn ($record) => is_null($record)),
                        ]),
                ])
                ->model($this->getUser())
                ->statePath('profileData');
    }

    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament::resources.user.profile.form.password_section.heading'))
                    ->description(__('filament::resources.user.profile.form.password_section.description'))
                    ->aside()
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label(__('filament::resources.user.profile.form.password_section.current_pwd'))
                            ->password()
                            ->required()
                            ->currentPassword(),
                        Forms\Components\TextInput::make('password')
                            ->label(__('filament::resources.user.profile.form.password_section.new_pwd'))
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->confirmed()
                            ->autocomplete('new-password')
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('filament::resources.user.profile.form.password_section.pwd_confirmation'))
                            ->password()
                            ->required()
                            ->dehydrated(false),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->action('submitEditProfileForm'),
        ];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->action('submitEditPasswordForm'),
        ];
    }

    public function submitEditProfileForm(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification();
    }

    public function submitEditPasswordForm(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification();
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        if (isset($data['email']) && $record->email != $data['email']) {
            $data['email_verified_at'] = null;
        }

        $record->update($data);
        return $record;
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (!$user instanceof Model) {
            throw new \Exception(__('filament::resources.user.profile.form.user_not_model_instance'));
        }
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->send();
    }
}
