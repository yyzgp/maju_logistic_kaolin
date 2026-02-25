<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Page extends Model
{
    use HasSlug;
    protected $fillable = [
        'name',
        'slug',
        'content',
        'extras',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'banner',
    ];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
