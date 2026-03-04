<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPackage extends Model
{
    protected $table = 'event_packages';

    protected $fillable = [
        'name','subtitle','description','price','features',
        'is_featured','sort_order','is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
}