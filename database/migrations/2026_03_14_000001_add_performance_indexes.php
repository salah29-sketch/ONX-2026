<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexes extends Migration
{
    public function up(): void
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();

        // clients table
        Schema::table('clients', function (Blueprint $table) use ($sm) {
            $indexes = array_keys($sm->listTableIndexes('clients'));
            if (!in_array('clients_email_index', $indexes)) $table->index('email');
            if (!in_array('clients_phone_index', $indexes)) $table->index('phone');
        });

        // appointments table
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) use ($sm) {
                $indexes = array_keys($sm->listTableIndexes('appointments'));
                if (!in_array('appointments_client_id_index', $indexes))   $table->index('client_id');
                if (!in_array('appointments_employee_id_index', $indexes)) $table->index('employee_id');
                if (!in_array('appointments_start_time_index', $indexes))  $table->index('start_time');
                if (!in_array('appointments_status_index', $indexes))      $table->index('status');
            });
        }

        // users table
        Schema::table('users', function (Blueprint $table) use ($sm) {
            $indexes = array_keys($sm->listTableIndexes('users'));
            if (!in_array('users_email_index', $indexes)) $table->index('email');
        });

        // appointment_service pivot
        if (Schema::hasTable('appointment_service')) {
            Schema::table('appointment_service', function (Blueprint $table) use ($sm) {
                $indexes = array_keys($sm->listTableIndexes('appointment_service'));
                if (!in_array('appointment_service_appointment_id_index', $indexes)) $table->index('appointment_id');
                if (!in_array('appointment_service_service_id_index', $indexes))     $table->index('service_id');
            });
        }
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
