<?php

namespace App\Filament\Resources\DoctorOrderResource\Pages;

use App\Filament\Resources\DoctorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctorOrder extends CreateRecord
{
    protected static string $resource = DoctorOrderResource::class;
}
