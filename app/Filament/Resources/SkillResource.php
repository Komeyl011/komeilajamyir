<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Filament\Resources\SkillResource\RelationManagers;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SkillResource extends BaseResource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.main');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('skill_name')
                    ->label(__('filament::resources.skill.table.skill_name.label'))
                    ->required(),
                Forms\Components\TextInput::make('proficiency')
                    ->label(__('filament::resources.skill.table.proficiency.label'))
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                parent::autoCreateColumns()
            )
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(
            parent::autoCreateInfolist()
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSkills::route('/'),
//            'create' => Pages\CreateSkill::route('/create'),
//            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
