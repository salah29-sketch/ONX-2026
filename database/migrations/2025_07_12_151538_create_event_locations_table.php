<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventlocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');     // اسم القاعة
            $table->string('address');  // العنوان
            $table->timestamps();       // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_locations');
    }
}
