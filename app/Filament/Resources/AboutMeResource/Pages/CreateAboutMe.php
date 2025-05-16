<?php

namespace App\Filament\Resources\AboutMeResource\Pages;

use App\Filament\Resources\BaseResource\Pages\BaseCreateRecord;
use Filament\Actions;
use App\Filament\Resources\AboutMeResource;

class CreateAboutMe extends BaseCreateRecord
{
    protected static string $resource = AboutMeResource::class;
}
