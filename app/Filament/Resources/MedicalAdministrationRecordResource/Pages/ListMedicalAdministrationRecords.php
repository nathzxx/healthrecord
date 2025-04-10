<?php

namespace App\Filament\Resources\MedicalAdministrationRecordResource\Pages;

use App\Filament\Resources\MedicalAdministrationRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicalAdministrationRecords extends ListRecords
{
    protected static string $resource = MedicalAdministrationRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
