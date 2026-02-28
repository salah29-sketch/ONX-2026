<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'appointments';

    protected $dates = [
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'finish_time',
    ];

protected $fillable = [
    'price',
    'deposit',
    'comments',
    'client_id',
    'start_time',
    'created_at',
    'updated_at',
    'deleted_at',
    'employee_id',
    'finish_time',
    'status',
    'event_location_id',          // ضروري للعلاقة
    'custom_event_location',      // ضروري لعنوان مخصص
];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

 public function eventLocation()
{
    return $this->belongsTo(EventLocation::class, 'event_location_id');
}


}
