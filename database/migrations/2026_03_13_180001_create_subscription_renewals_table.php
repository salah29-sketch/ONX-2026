<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * سجل تجديدات الاشتراك (للتاريخ والمحاسبة)
 * كل تجديد يدوي أو تلقائي يُسجَّل هنا
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            /** تاريخ/وقت التجديد */
            $table->dateTime('renewed_at');
            /** next_billing_date بعد هذا التجديد */
            $table->date('next_billing_date');
            /** نوع التجديد: manual / automatic */
            $table->enum('renewal_type', ['manual', 'automatic']);
            /** المبلغ إذا تم ربطه بمدفوعة (اختياري) */
            $table->decimal('amount', 12, 2)->nullable();
            $table->timestamps();

            $table->index(['subscription_id', 'renewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_renewals');
    }
};
