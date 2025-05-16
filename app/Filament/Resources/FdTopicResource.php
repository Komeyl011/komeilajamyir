<?php

namespace App\Filament\Resources;

use App\Enum\FdTypes;
use App\Filament\Resources\FdTopicResource\Pages;
use App\Filament\Resources\FdTopicResource\RelationManagers;
use App\Models\FdTopic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FdTopicResource extends BaseResource
{
    protected static ?string $model = FdTopic::class;


    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?int $navigationSort = 5;
//    protected static bool $shouldRegisterNavigation = false;
    protected static bool $isDiscovered = false;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.fd_topics');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament::resources.fd-topic.table.name.label'))
                    ->required()
                    ->regex('/^[a-zA-Z0-9\s\.\,\!\?\:\;\-\_\(\)\'\"]+$/'),
                Forms\Components\Select::make('type')
                    ->label(__('filament::resources.fd-topic.table.type.label'))
                    ->required()
                    ->options(FdTypes::labels()),
                Forms\Components\RichEditor::make('description')
                    ->label(__('filament::resources.fd-topic.table.description.label'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                parent::autoCreateColumns()
            )
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(FdTypes::labels())
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(
            parent::autoCreateInfolist()
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFdTopics::route('/'),
        ];
    }
}
