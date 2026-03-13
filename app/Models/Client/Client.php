<?php

namespace App\Models\Client;

use App\Models\Booking\Booking;
use App\Models\Content\Testimonial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Client extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'login_disabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'login_disabled'    => 'boolean',
    ];

    public function setPasswordAttribute($value): void
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function messages()
    {
        return $this->hasMany(ClientMessage::class);
    }

    public function photos()
    {
        return $this->hasMany(ClientPhoto::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function hasPassword(): bool
    {
        return !empty($this->password);
    }

    public function selectedPhotos()
    {
        return $this->hasMany(ClientSelectedPhoto::class);
    }

    public function mediaSeen()
    {
        return $this->hasMany(ClientMediaSeen::class);
    }

    public function messagesSeen()
    {
        return $this->hasOne(ClientMessagesSeen::class);
    }
}
