<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexes extends Migration
{
    public function up(): void
    {
        // clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->index('email');
            $table->index('phone');
        });

        // appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->index('client_id');
            $table->index('employee_id');
            $table->index('start_time');
            $table->index('status');
        });

        // users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
        });

        // appointment_service pivot
        Schema::table('appointment_service', function (Blueprint $table) {
            $table->index('appointment_id');
            $table->index('service_id');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['phone']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['start_time']);
            $table->dropIndex(['status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });

        Schema::table('appointment_service', function (Blueprint $table) {
            $table->dropIndex(['appointment_id']);
            $table->dropIndex(['service_id']);
        });
    }
}
