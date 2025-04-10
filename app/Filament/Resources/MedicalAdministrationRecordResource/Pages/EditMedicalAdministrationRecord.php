<?php

namespace App\Filament\Resources\MedicalAdministrationRecordResource\Pages;

use App\Filament\Resources\MedicalAdministrationRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicalAdministrationRecord extends EditRecord
{
    protected static string $resource = MedicalAdministrationRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return MedicalAdministrationRecordResource::getUrl('index'); // Redirect to the index (list) page after create
    }
}
