<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type',
        'name',
        'phone',
        'email',
        'event_date',
        'event_location_id',
        'custom_event_location',
        'business_name',
        'budget',
        'deadline',
        'package_type',
        'package_id',
        'notes',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'deadline'   => 'date',
        'budget'     => 'decimal:2',
    ];

    public function eventLocation()
    {
        return $this->belongsTo(EventLocation::class, 'event_location_id');
    }

    public function eventPackage()
    {
        return $this->belongsTo(EventPackage::class, 'package_id');
    }

    public function adPackage()
    {
        return $this->belongsTo(AdPackage::class, 'package_id');
    }
    public function client()
{
    return $this->belongsTo(Client::class);
}
}