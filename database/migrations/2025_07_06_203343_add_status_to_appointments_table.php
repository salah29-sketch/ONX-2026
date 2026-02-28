<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAppointmentsTable extends Migration
{
   public function up()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->boolean('status')->default(0); // 0 = غير مؤكد
    });
}

public function down()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
}
