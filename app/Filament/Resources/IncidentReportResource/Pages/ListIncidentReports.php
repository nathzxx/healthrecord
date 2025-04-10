<?php

namespace App\Filament\Resources\IncidentReportResource\Pages;

use App\Filament\Resources\IncidentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidentReports extends ListRecords
{
    protected static string $resource = IncidentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
