<?php

namespace App\Filament\Resources\DersResource\Pages;

use App\Filament\Resources\DersResource;
use App\Filament\Support\DersForm;
use Filament\Resources\Pages\CreateRecord;

class CreateDers extends CreateRecord
{
    protected static string $resource = DersResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return DersForm::processPdfPageCount($data);
    }
}
