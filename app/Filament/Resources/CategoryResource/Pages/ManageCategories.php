<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\BaseResource\Pages\GetTranslations;
use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageCategories extends ManageRecords
{
    use GetTranslations;
    
    protected static string $resource = CategoryResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['slug'] = Str::slug($data['name_translated_en']);

                    return $this->mutateData($data);
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['slug'] = Str::slug($data['name_translated_en']);

                    return $this->mutateData($data);
                }),
        ];
    }
}
