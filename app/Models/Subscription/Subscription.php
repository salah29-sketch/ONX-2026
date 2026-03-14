<?php

namespace App\Models\Subscription;

use App\Models\Client\Client;
use App\Models\Booking\Booking;
use App\Models\Event\AdPackage;
use Illuminate\Database\Eloquent\Model;

/**
 * اشتراك شهري في باقة إعلانات
 * يُنشأ عند حجز عميل لباقة إعلان شهرية (ads_type=monthly)
 */
class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'client_id',
        'booking_id',
        'ad_package_id',
        'start_date',
        'next_billing_date',
        'renewal_type',
        'status',
    ];

    protected $casts = [
        'start_date'        => 'date',
        'next_billing_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /** الحجز الأصلي الذي أنشأ الاشتراك */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function adPackage()
    {
        return $this->belongsTo(AdPackage::class);
    }

    public function renewals()
    {
        return $this->hasMany(SubscriptionRenewal::class)->orderByDesc('renewed_at');
    }

    /** اسم الخطة (من الباقة) */
    public function planName(): string
    {
        return $this->adPackage?->name ?? '—';
    }

    /** تسمية نوع التجديد */
    public function renewalTypeLabel(): string
    {
        return match ($this->renewal_type ?? 'manual') {
            'automatic' => 'تلقائي',
            'manual'    => 'يدوي',
            default     => $this->renewal_type,
        };
    }

    /** تسمية الحالة */
    public function statusLabel(): string
    {
        return match ($this->status ?? 'active') {
            'active'    => 'نشط',
            'expired'   => 'منتهي',
            'cancelled' => 'ملغى',
            default     => $this->status,
        };
    }

    /** هل الاشتراك قابل للتجديد (نشط ولم ينتهِ) */
    public function isRenewable(): bool
    {
        return $this->status === 'active';
    }
}
