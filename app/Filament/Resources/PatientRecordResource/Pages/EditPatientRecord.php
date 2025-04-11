<?php

namespace App\Filament\Resources\PatientRecordResource\Pages;

use App\Filament\Resources\PatientRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatientRecord extends EditRecord
{
    protected static string $resource = PatientRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $riskLevel = 'Low';
        $recommendation = 'Patient is stable.';

        if ((float) $data['temperature'] > 38 || (int) $data['pulse'] > 100) {
            $riskLevel = 'High';
            $recommendation = 'Monitor closely.';
        } elseif ((float) $data['temperature'] >= 37.5 || (int) $data['pulse'] > 90) {
            $riskLevel = 'Moderate';
            $recommendation = 'Needs observation.';
        }

        $data['cdss_risk_level'] = $riskLevel;
        $data['cdss_recommendations'] = $recommendation;

        return $data;
    }
}
