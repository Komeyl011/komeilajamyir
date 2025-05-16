<?php

namespace App\Filament\Resources\ChatBotUserResource\Pages;

use App\Filament\Resources\ChatBotUserResource;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRecords;

class ManageChatBotUsers extends ManageRecords
{
    protected static string $resource = ChatBotUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
