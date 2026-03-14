<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * جدول الاشتراكات الشهرية للإعلانات
 * يربط العميل بباقة الإعلان الشهرية مع تواريخ البدء والتجديد
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            /** clients.id هو unsignedInteger في هذا المشروع */
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            /** الحجز الأصلي الذي أنشأ الاشتراك (مرجع للطلب الأول) */
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            /** باقة الإعلان الشهرية (ad_packages.type = monthly) */
            $table->foreignId('ad_package_id')->constrained('ad_packages')->cascadeOnDelete();
            /** تاريخ بدء الاشتراك (من تاريخ اختيار العميل عند الحجز) */
            $table->date('start_date');
            /** تاريخ التجديد القادم (يُحدَّث عند كل تجديد شهري) */
            $table->date('next_billing_date');
            /** نوع التجديد: manual = يدوي، automatic = تلقائي */
            $table->enum('renewal_type', ['manual', 'automatic'])->default('manual');
            /** الحالة: active = نشط، expired = منتهي، cancelled = ملغى */
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index('next_billing_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
