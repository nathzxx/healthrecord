<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'contact_number',
        'emergency_contact',
        'temperature',
        'pulse',
        'respiration_rate',
        'blood_pressure',
        'general_appearance',
        'head_eyes_ears_nose_throat',
        'respiratory',
        'cardiovascular',
        'abdomen',
        'musculoskeletal',
        'neurological',
        'observations',
        'recommendations',
        'nurse_name',
        'date',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date' => 'date',
    ];
}
