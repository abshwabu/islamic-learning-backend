<?php

namespace App\Filament\Resources\DersResource\Pages;

use App\Filament\Resources\DersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDers extends ListRecords
{
    protected static string $resource = DersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
