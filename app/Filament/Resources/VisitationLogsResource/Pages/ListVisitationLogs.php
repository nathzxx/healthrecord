<?php

namespace App\Filament\Resources\VisitationLogsResource\Pages;

use App\Filament\Resources\VisitationLogsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitationLogs extends ListRecords
{
    protected static string $resource = VisitationLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
