<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'badge',
        'badge_color',
        'features',
        'slug',
        'link',
        'start_date',
        'end_date',
        'order',
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
