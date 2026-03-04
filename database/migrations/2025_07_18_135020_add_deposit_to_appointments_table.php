<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepositToAppointmentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('appointments', 'deposit')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->decimal('deposit', 10, 2)->nullable()->after('price'); // مبلغ العربون
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('appointments', 'deposit')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('deposit');
            });
        }
    }
}