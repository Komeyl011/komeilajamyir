<?php

namespace App\Filament\Resources\FdTopicResource\Pages;

use App\Filament\Resources\FdTopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFdTopics extends ManageRecords
{
    protected static string $resource = FdTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
