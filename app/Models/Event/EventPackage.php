<?php

namespace App\Models\Event;

use App\Models\Booking\Booking;
use Illuminate\Database\Eloquent\Model;

class EventPackage extends Model
{
    protected $table = 'event_packages';

    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'price',
        'old_price',
        'features',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features'    => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'price'       => 'decimal:2',
        'old_price'   => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id')
            ->where('service_type', 'event');
    }
}
