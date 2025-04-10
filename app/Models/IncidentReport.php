<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    protected $fillable =[
      'Incident',
      'Time',
      'Date'  
    ];
}
