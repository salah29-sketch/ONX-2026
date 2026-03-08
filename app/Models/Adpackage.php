<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adpackage extends Model
{
    protected $fillable = [
        'type','name','subtitle','description','price','price_note',
        'features','is_featured','sort_order','is_active'
    ];

   protected $casts = [
    'features'    => 'array',
    'is_active'   => 'boolean',
    'is_featured' => 'boolean',
    'price'       => 'decimal:2',
];
public function bookings()
{
  return $this->morphMany(\App\Models\Booking::class, 'package');
}
}