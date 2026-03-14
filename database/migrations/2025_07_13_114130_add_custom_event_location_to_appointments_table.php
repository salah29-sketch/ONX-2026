<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomEventLocationToAppointmentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('appointments', 'custom_event_location')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->string('custom_event_location')->nullable()->after('event_location_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('appointments', 'custom_event_location')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('custom_event_location');
            });
        }
    }
}