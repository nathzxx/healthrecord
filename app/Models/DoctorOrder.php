<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_record_id',
        'patient_name',
        'doctor_name',
        'order',
    ];

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }
}
