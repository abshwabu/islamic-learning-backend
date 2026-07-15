<?php

namespace App\Filament\Resources\DersResource\Pages;

use App\Filament\Resources\DersResource;
use App\Filament\Support\DersForm;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDers extends EditRecord
{
    protected static string $resource = DersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return DersForm::processPdfPageCount($data);
    }
}
