<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalAdministrationRecord extends Model
{
    protected $fillable = [
        'PatientName',
        'Doctor/Nurse',
        'MedicationGiven',
        'Time',
        'Date',
        'SideEffect'

    ];
}
