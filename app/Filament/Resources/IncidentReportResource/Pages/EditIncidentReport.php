<?php

namespace App\Filament\Resources\IncidentReportResource\Pages;

use App\Filament\Resources\IncidentReportResource;
use App\Models\IncidentReport;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncidentReport extends EditRecord
{
    protected static string $resource = IncidentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return IncidentReportResource::getUrl('index'); // Redirect to the index (list) page after create
    }
}
