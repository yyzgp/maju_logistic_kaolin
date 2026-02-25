<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SingaporeLocation extends Model
{
    protected $fillable = [
        'place',
        'city',
        'area',
        'latitude',
        'longitude',
        'bounding_box_1',
        'bounding_box_2',
        'bounding_box_3',
        'bounding_box_4',
    ];
}
