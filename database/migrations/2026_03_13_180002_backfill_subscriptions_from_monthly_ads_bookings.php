<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * إنشاء سجلات اشتراك للحجوزات الإعلانية الشهرية القديمة التي لم يُنشأ لها اشتراك
 * (للاستجابة لمتطلبات: اعتبار الباقات الشهرية اشتراكات في منطقة العملاء)
 */
return new class extends Migration
{
    public function up(): void
    {
        $table = 'subscriptions';
        if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
            return;
        }

        $bookings = DB::table('bookings')
            ->where('service_type', 'ads')
            ->where('ads_type', 'monthly')
            ->whereNotNull('client_id')
            ->whereNotNull('event_date')
            ->whereNotNull('package_id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('subscriptions')
                    ->whereColumn('subscriptions.booking_id', 'bookings.id');
            })
            ->get();

        foreach ($bookings as $b) {
            $startDate = \Carbon\Carbon::parse($b->event_date);
            $nextBilling = $startDate->copy()->addMonth();
            DB::table('subscriptions')->insert([
                'client_id'         => $b->client_id,
                'booking_id'        => $b->id,
                'ad_package_id'     => $b->package_id,
                'start_date'        => $startDate->format('Y-m-d'),
                'next_billing_date' => $nextBilling->format('Y-m-d'),
                'renewal_type'      => 'manual',
                'status'            => 'active',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }

    public function down(): void
    {
        // لا نرجع الاشتراكات المُنشأة من الحجوزات القديمة تلقائياً (يمكن حذفها يدوياً إن لزم)
    }
};
