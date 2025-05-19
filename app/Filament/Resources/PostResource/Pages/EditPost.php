<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\BaseResource\Pages\BaseEditRecord;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Illuminate\Support\Str;

class EditPost extends BaseEditRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = Str::slug($data['title_translated_en']);
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
