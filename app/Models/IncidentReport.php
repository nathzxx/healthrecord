<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    protected $fillable =[
      'username',
      'name_involve',
      'contact',
      'Incident',
      'Time',
      'Date',
      'IncidentLocation',
      'IncidentType',
      'IncidentTime',
      'IncidentDate'
    ];
}
