<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventLocation;
use App\Models\EventPackage;
use App\Models\Adpackage;

class Booking extends Model
{
    protected $fillable = [
        'service_type',      // event | ads
        'name',
        'phone',
        'email',

        'package_type',      // class name (morph)
        'package_id',

        // event fields
        'event_date',
        'event_location_id',
        'custom_event_location',

        // ads fields
        'business_name',
        'budget',
        'deadline',

        'notes',
        'status',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function eventLocation()
    {
        return $this->belongsTo(EventLocation::class, 'event_location_id');
    }

    public function eventPackage()
    {
        return $this->belongsTo(EventPackage::class, 'package_id');
    }

    public function adpackage()
    {
        return $this->belongsTo(Adpackage::class, 'package_id');
    }
}