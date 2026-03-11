<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPhoto extends Model
{
    protected $fillable = ['booking_id', 'path', 'sort_order'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function clientSelections()
    {
        return $this->hasMany(ClientSelectedPhoto::class, 'booking_photo_id');
    }
}
