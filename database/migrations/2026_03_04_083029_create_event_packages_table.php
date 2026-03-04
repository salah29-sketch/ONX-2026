<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Basic / Standard / Premium
            $table->string('subtitle')->nullable(); // الأكثر طلبًا...
            $table->text('description')->nullable();
            $table->integer('price')->nullable();   // 30000
            $table->json('features')->nullable();   // ["ميزة1", "ميزة2"]
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_packages');
    }
};