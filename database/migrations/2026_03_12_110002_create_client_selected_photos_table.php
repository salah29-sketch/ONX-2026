<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_selected_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');
            $table->unsignedBigInteger('booking_photo_id');
            $table->timestamps();

            $table->unique(['client_id', 'booking_photo_id']);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('booking_photo_id')->references('id')->on('booking_photos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_selected_photos');
    }
};
