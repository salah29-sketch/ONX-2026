<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToEventLocationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('event_locations', 'deleted_at')) {
            Schema::table('event_locations', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::table('event_locations', function (Blueprint $table) {
            if (Schema::hasColumn('event_locations', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
}