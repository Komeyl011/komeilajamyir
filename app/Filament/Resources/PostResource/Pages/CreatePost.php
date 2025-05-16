<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\BaseResource\Pages\BaseCreateRecord;
use App\Filament\Resources\PostResource;

class CreatePost extends BaseCreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author_id'] = auth()->user()->id;
        return parent::mutateFormDataBeforeCreate($data);
    }
}
