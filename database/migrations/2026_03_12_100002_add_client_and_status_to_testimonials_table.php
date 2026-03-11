<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->unsignedInteger('client_id')->nullable()->after('id');
            $table->unsignedBigInteger('booking_id')->nullable()->after('client_id');
            $table->string('status', 20)->default('pending')->after('content'); // pending, approved, rejected
        });
        \DB::table('testimonials')->where('is_active', 1)->update(['status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['client_id', 'booking_id', 'status']);
        });
    }
};
