<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabOrder extends Model
{
    protected $fillable = [
        'patient_record_id',
        'patient_name',
        'doctor_name',
        'lab_order',
    ];

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }
}
