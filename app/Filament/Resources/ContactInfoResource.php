<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInfoResource\Pages;
use App\Filament\Resources\ContactInfoResource\RelationManagers;
use App\Models\ContactInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactInfoResource extends BaseResource
{
    protected static ?string $model = ContactInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-arrow-down-left';
    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.main');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                self::autoCreateInputs(),
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('platform')
                    ->label(__('filament::resources.contact-info.table.platform.label')),
                Tables\Columns\TextColumn::make('icon')
                    ->label(__('filament::resources.contact-info.table.icon.label'))
                    ->state(fn ($record) => "<i class='$record->icon text-xl'></i>")
                    ->html()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('url')
                    ->label(__('filament::resources.contact-info.table.url.label')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContactInfos::route('/'),
        ];
    }
}
