<?php

namespace App\Filament\Resources\PatientRecordResource\Pages;

use App\Filament\Resources\PatientRecordResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewPatientRecord extends ViewRecord
{
    protected static string $resource = PatientRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('Write Doctor Order')
                ->label('Write Doctor Order')
                ->visible(fn () => Auth::user()?->hasRole('doctor')) // Only show to doctors
                ->url(fn () => route('filament.admin.resources.doctor-orders.create', [
                    'patient_record_id' => $this->record->id,
                    'patient_name' => $this->record->name,
                    'doctor_name' => Auth::user()?->name,
                ]))
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }
}
