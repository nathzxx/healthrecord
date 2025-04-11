<?php

namespace App\Filament\Resources\DoctorOrderResource\Pages;

use App\Filament\Resources\DoctorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoctorOrder extends EditRecord
{
    protected static string $resource = DoctorOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
