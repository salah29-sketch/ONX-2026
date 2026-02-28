<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialLinksToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
        {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('facebook')->nullable();
                $table->string('instagram')->nullable();
                $table->string('twitter')->nullable();
                $table->string('linkedin')->nullable();
            });
        }

        public function down()
        {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn(['facebook', 'instagram', 'twitter', 'linkedin']);
            });
        }
}
