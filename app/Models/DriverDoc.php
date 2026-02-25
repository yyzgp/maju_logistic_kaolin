<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverDoc extends Model
{
    protected $fillable = [
      'driver_id',
      'document',
      'file',
      'status'
    ];
}
