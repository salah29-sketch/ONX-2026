<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocaleToEditableContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editable_contents', function (Blueprint $table) {
                  $table->string('locale')->default('fr');
                  $table->unique(['key', 'locale']); // لمنع تكرار نفس المفتاح لنفس اللغة
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editable_contents', function (Blueprint $table) {
            //
        });
    }
}
