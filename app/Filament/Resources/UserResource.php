<?php

namespace App\Filament\Resources;

use App\Enum\YesNo;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends BaseResource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament::resources.user.table.name.label'))
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label(__('filament::resources.user.table.email.label'))
                    ->required()
                    ->email(),
                Forms\Components\FileUpload::make('avatar')
                    ->label(__('filament::resources.user.table.avatar.label'))
                    ->default('users/default.png'),
                Forms\Components\TextInput::make('password')
                    ->label(__('filament::resources.user.table.password.label'))
                    ->required()
                    ->password()
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament::resources.user.table.name.label')),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament::resources.user.table.email.label')),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('filament::resources.user.table.role.label')),
                Tables\Columns\ImageColumn::make('avatar')
                    ->label(__('filament::resources.user.table.avatar.label')),
//                Tables\Columns\ToggleColumn::make('email_verified_at')
//                    ->label(__('filament::resources.user.table.email_verified_at.label')),
                Tables\Columns\TextColumn::make('email_verified')
                    ->label(__('filament::resources.user.table.email_verified.label'))
                    ->badge()
                    ->formatStateUsing(fn (?YesNo $state) => $state?->label())
                    ->color(fn (?YesNo $state) => $state?->color()),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label(__('filament::resources.user.table.email_verified_at.label'))
                    ->nullable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\RoleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
