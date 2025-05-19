<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\BaseResource\Pages\BaseCreateRecord;
use App\Filament\Resources\PostResource;
use Illuminate\Support\Str;

class CreatePost extends BaseCreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = Str::slug($data['title_translated_en']);
        $data['author_id'] = auth()->user()->id;
        return parent::mutateFormDataBeforeCreate($data);
    }
}
