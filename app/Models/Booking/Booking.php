<?php

namespace App\Models\Booking;

use App\Models\Client\Client;
use App\Models\Event\AdPackage;
use App\Models\Event\EventLocation;
use App\Models\Event\EventPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_type',
        'project_type',
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
        'final_video_path',
        'total_price',
    ];

    protected $casts = [
        'event_date'  => 'date',
        'deadline'    => 'date',
        'budget'      => 'decimal:2',
        'total_price' => 'decimal:2',
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

    public function photos()
    {
        return $this->hasMany(BookingPhoto::class, 'booking_id')->orderBy('sort_order');
    }

    public function payments()
    {
        return $this->hasMany(BookingPayment::class)->orderBy('paid_at');
    }

    public function files()
    {
        return $this->hasMany(BookingFile::class)->orderBy('created_at');
    }

    public function visibleFiles()
    {
        return $this->hasMany(BookingFile::class)->where('is_visible', true)->orderBy('created_at');
    }

    public function paidAmount(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function remainingAmount(): float
    {
        if (!$this->total_price) return 0;
        return max(0, (float) $this->total_price - $this->paidAmount());
    }

    public function paymentPercent(): int
    {
        if (!$this->total_price || $this->total_price <= 0) return 0;
        return min(100, (int) round(($this->paidAmount() / (float) $this->total_price) * 100));
    }

    public function isFullyPaid(): bool
    {
        return $this->total_price && $this->paidAmount() >= (float) $this->total_price;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'new'          => 'جديد',
            'unconfirmed'  => 'غير مؤكد',
            'confirmed'    => 'مؤكد',
            'in_progress'  => 'قيد التنفيذ',
            'completed'    => 'مكتمل',
            'cancelled'    => 'ملغى',
            default        => $this->status,
        };
    }

    public function statusStep(): int
    {
        return match ($this->status) {
            'new', 'unconfirmed' => 1,
            'confirmed'          => 2,
            'in_progress'        => 3,
            'completed'          => 4,
            default              => 0,
        };
    }

    public function deliveryInfoText(): string
    {
        return $this->service_type === 'event'
            ? 'يتم تسليم المنتج بعد شهر كحد أقصى من يوم الحفل'
            : 'موعد التسليم يحدده العميل مع الفريق';
    }

    public function projectTypeLabel(): string
    {
        $type = $this->project_type ?? $this->service_type;
        return match ($type) {
            'event'     => 'حفلات',
            'ads'       => 'إعلانات',
            'marketing' => 'تسويق',
            'personal'  => 'مشاريع شخصية',
            default     => $type ?: '—',
        };
    }
}
