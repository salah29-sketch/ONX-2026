<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('service_type')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('event_date')->nullable();
            $table->string('event_location_id')->nullable();
            $table->string('custom_event_location')->nullable();
            $table->string('business_name')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->date('deadline')->nullable();
            $table->string('package_type')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('unconfirmed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}