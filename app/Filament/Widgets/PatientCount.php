<?php

namespace App\Filament\Widgets;

use App\Models\PatientRecord;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PatientCount extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Patients', PatientRecord::count())
                ->icon('heroicon-o-user-group')
                ->color('primary')
                ->url(route('filament.admin.resources.patient-records.index')) ,
        ];
    }
}
