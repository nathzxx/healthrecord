<?php

namespace App\Filament\Resources\DoctorOrderResource\Pages;

use App\Filament\Resources\DoctorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctorOrders extends ListRecords
{
    protected static string $resource = DoctorOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
