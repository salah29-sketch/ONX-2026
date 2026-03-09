<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جداول appointments وكل pivot tables المرتبطة بها
        Schema::dropIfExists('appointment_service');
        Schema::dropIfExists('appointments');

        // جداول Models المحذوفة
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('home_contents');
        Schema::dropIfExists('service_homes');
    }

    public function down(): void
    {
        // appointments
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('appointment_service', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        // gallery_items
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        // home_contents
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        // service_homes
        Schema::create('service_homes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};