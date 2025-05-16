<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class PermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament::resources.permission.plural_label');
    }

    protected static function getPluralRecordLabel(): ?string
    {
        return __('filament::resources.permission.model_label');
    }

    protected static function getModelLabel(): ?string
    {
        return __('filament::resources.permission.model_label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->label(__('filament::resources.user.table.role.label'))
                    ->required()
                    ->options(fn () => Role::query()->pluck('name', 'id'))
                    ->default(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
