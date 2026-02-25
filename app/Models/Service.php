<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
        'extra_night_price',
        'type',
        'merchants',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'merchants' => 'json',
            'type' => 'json',
        ];
    }
}
