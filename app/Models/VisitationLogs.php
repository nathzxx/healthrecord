<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitationLogs extends Model
{
    protected $fillable = [
        'Reason',
        'Time',
        'Date',
        'InterventionProvided',
        'FollowUps'
    ];
}
