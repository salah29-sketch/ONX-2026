<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_role')->nullable(); // مثل: عميل — إعلان تجاري
            $table->string('subtitle')->nullable();    // مثل: علامة تجارية
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(5); // 1-5
            $table->string('initial')->nullable();     // حرف أول للعرض (م، س، خ)
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
