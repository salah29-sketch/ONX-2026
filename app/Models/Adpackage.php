<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdPackage extends Model
{
    protected $table = 'ad_packages';

    protected $fillable = [
        'type',
        'name',
        'subtitle',
        'description',
        'price',
        'old_price',
        'price_note',
        'features',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features'    => 'array',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'price'       => 'decimal:2',
        'old_price'   => 'decimal:2',
    ];

    public function bookings()
{
    return $this->hasMany(\App\Models\Booking::class, 'package_id')
        ->where('service_type', 'ads');
}
}