<?php

namespace App\Filament\Resources\BaseResource\Pages;

use Filament\Resources\Pages\CreateRecord;

abstract class BaseCreateRecord extends CreateRecord
{
    use GetTranslations;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->mutateData($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
