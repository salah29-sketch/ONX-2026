<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $table = 'services';

    protected $fillable = [
        'name',
        'title',
        'description',
        'price',
        'icon',
        'features',
        'image',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    // ─── Relations ───────────────────────────────────────────
    // ✅ مستخدمة في EmployeesController و main.blade.php
    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    // ❌ تم حذف: appointments() — غير مستخدمة بعد حذف Appointments
}
