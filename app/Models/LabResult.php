<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    protected $fillable = [
        
        'lab_order_id',
        'lab_order',
        'patient_name',
        'doctor_name',
        'result',
        'file'
    ];



    public function labOrder()
    {
        return $this->belongsTo(LabOrder::class);
    }
}
