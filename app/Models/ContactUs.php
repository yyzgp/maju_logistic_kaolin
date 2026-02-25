<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
        'user_id',
        'user',
        'source',
        'name',
        'email',
        'phone',
        'message'
    ];
}
