<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddClientIdToBookingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('bookings', 'client_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->unsignedInteger('client_id')->nullable()->after('id');
            });
        }

        $foreignExists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'bookings'
              AND COLUMN_NAME = 'client_id'
              AND REFERENCED_TABLE_NAME = 'clients'
        ");

        if (empty($foreignExists)) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->nullOnDelete();
            });
        }
    }

    public function down()
    {
        $foreignExists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'bookings'
              AND COLUMN_NAME = 'client_id'
              AND REFERENCED_TABLE_NAME = 'clients'
        ");

        if (!empty($foreignExists)) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropForeign(['client_id']);
            });
        }
    }
}