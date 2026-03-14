<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add SaaS-style fields to subscriptions table.
 * - end_date: optional end of subscription period
 * - cancelled_at: when the subscription was cancelled
 * - plan_price: snapshot of package price at subscription time
 * - used_ads: count of ads used (default 0)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'end_date')) {
                $table->date('end_date')->nullable()->after('next_billing_date');
            }
            if (!Schema::hasColumn('subscriptions', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('subscriptions', 'plan_price')) {
                $table->decimal('plan_price', 12, 2)->nullable()->after('ad_package_id');
            }
            if (!Schema::hasColumn('subscriptions', 'used_ads')) {
                $table->unsignedInteger('used_ads')->default(0)->after('plan_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'cancelled_at', 'plan_price', 'used_ads']);
        });
    }
};
