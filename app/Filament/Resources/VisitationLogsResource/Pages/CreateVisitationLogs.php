<?php

namespace App\Filament\Resources\VisitationLogsResource\Pages;

use App\Filament\Resources\VisitationLogsResource;
use App\Models\VisitationLogs;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitationLogs extends CreateRecord
{
    protected static string $resource = VisitationLogsResource::class;

    protected function getRedirectUrl(): string
    {
        return VisitationLogsResource::getUrl('index'); // Redirect to the index (list) page after create
    }
}
