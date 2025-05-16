<?php

namespace App\Filament\Resources\BaseResource\Pages;

use Filament\Resources\Pages\EditRecord;

abstract class BaseEditRecord extends EditRecord
{
    use GetTranslations;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->mutateData($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
