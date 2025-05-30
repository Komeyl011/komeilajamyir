<?php

namespace App\Filament\Resources\ContactFormResource\Pages;

use App\Filament\Resources\ContactFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContactForms extends ManageRecords
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
