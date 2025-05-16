<?php

namespace App\Filament\Resources;

use App\Enum\Priority;
use App\Filament\Resources\ContactFormResource\Pages;
use App\Filament\Resources\ContactFormResource\RelationManagers;
use App\Models\ContactForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

class ContactFormResource extends BaseResource
{
    protected static ?string $model = ContactForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.users');
    }

    private static function getUnansweredRequests(): ?string
    {
        return static::getModel()::where('answered', '=', false)->count() ?: null;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getUnansweredRequests();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $count = static::getUnansweredRequests();
        return $count > 0
            ? 'danger'
            : 'success';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                parent::autoCreateColumns(),
            )
            ->filters([
                Tables\Filters\TernaryFilter::make('answered')
                    ->label(__('filament::resources.contact-form.table.answered.label')),
                Tables\Filters\SelectFilter::make('priority')
                    ->label(__('filament::resources.contact-form.table.priority.label'))
                    ->options(fn () => Priority::labels()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('reply')
                    ->label(__('filament::resources.contact-form.reply_action.label'))
                    ->color(__('filament::resources.contact-form.reply_action.color'))
                    ->icon(__('filament::resources.contact-form.reply_action.icon'))
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->label(__('filament::resources.contact-form.reply_action.message'))
                            ->required()
                            ->rows(10)
                            ->cols(20)
                            ->extraAttributes(fn ($record) => ['dir' => $record->locale == 'fa' ? 'rtl' : 'ltr']),
                    ])
                    ->action(function (array $data, ContactForm $record) {
                        Mail::to($record->email)->send(new \App\Mail\ContactReplyMail(locale: $record->locale, record: $record, message: $data['message']));

                        $record->update(['answered' => true]);

                        Notification::make()
                            ->success()
                            ->title(__('filament::notifications.email_sent'))
                            ->body(__('filament::notifications.reply_email_sent'))
                            ->send();
                    })
                    ->modalHeading(__('filament::resources.contact-form.reply_action.modal_heading'))
                    ->modalSubmitActionLabel(__('filament::resources.contact-form.reply_action.modal_submit_action'))
                    ->visible(fn ($record) => ! $record->answered->value),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(
            parent::autoCreateInfolist(),
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContactForms::route('/'),
//            'create' => Pages\CreateContactForm::route('/create'),
//            'edit' => Pages\EditContactForm::route('/{record}/edit'),
        ];
    }
}
