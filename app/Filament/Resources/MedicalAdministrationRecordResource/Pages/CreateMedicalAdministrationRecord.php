<?php

namespace App\Filament\Resources\MedicalAdministrationRecordResource\Pages;

use App\Filament\Resources\MedicalAdministrationRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicalAdministrationRecord extends CreateRecord
{
    protected static string $resource = MedicalAdministrationRecordResource::class;

    protected function getRedirectUrl(): string
    {
        return MedicalAdministrationRecordResource::getUrl('index'); // Redirect to the index (list) page after create
    }
}
