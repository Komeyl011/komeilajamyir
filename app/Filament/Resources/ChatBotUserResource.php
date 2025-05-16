<?php

namespace App\Filament\Resources;

use App\Enum\YesNo;
use App\Filament\Resources\ChatBotUserResource\Pages;
use App\Filament\Resources\ChatBotUserResource\RelationManagers;
use App\Models\ChatBotUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatBotUserResource extends BaseResource
{
    protected static ?string $model = ChatBotUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.telegram_bot');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('chat_id')
                    ->label(__('filament::resources.chat-bot-user.table.chat_id.label'))
                    ->disabled(),
                Forms\Components\TextInput::make('username')
                    ->label(__('filament::resources.chat-bot-user.table.username.label')),
                Forms\Components\Toggle::make('is_bot')
                    ->label(__('filament::resources.chat-bot-user.table.is_bot.label'))
                    ->inlineLabel(),
                Forms\Components\Toggle::make('is_premium')
                    ->label(__('filament::resources.chat-bot-user.table.is_premium.label'))
                    ->inlineLabel(),
                Forms\Components\Toggle::make('has_subscription')
                    ->label(__('filament::resources.chat-bot-user.table.has_subscription.label'))
                    ->inlineLabel(),
                Forms\Components\TextInput::make('balance')
                    ->label(__('filament::resources.chat-bot-user.table.balance.label'))
                    ->numeric(),
                Forms\Components\TextInput::make('remaining_requests_count')
                    ->label(__('filament::resources.chat-bot-user.table.remaining_requests_count.label'))
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                parent::autoCreateColumns(),
            )
            ->filters([
                Tables\Filters\TernaryFilter::make('is_bot')
                    ->label(__('filament::resources.chat-bot-user.table.is_bot.label')),
                Tables\Filters\TernaryFilter::make('is_premium')
                    ->label(__('filament::resources.chat-bot-user.table.is_premium.label')),
                Tables\Filters\TernaryFilter::make('has_subscription')
                    ->label(__('filament::resources.chat-bot-user.table.has_subscription.label')),
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
            parent::autoCreateInfolist(),
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageChatBotUsers::route('/'),
        ];
    }
}
