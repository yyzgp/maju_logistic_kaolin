<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverTask extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'status',
        'decline_reason',
    ];

}
