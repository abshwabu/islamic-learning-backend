<?php

namespace App\Filament\Resources\UstazResource\Pages;

use App\Filament\Resources\UstazResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUstazs extends ListRecords
{
    protected static string $resource = UstazResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
