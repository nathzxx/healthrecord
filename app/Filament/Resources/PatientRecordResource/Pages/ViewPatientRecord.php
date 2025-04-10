<?php

namespace App\Filament\Resources\PatientRecordResource\Pages;

use App\Filament\Resources\PatientRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPatientRecord extends ViewRecord
{
    protected static string $resource = PatientRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
