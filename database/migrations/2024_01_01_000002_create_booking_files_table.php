<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('label');                  // الاسم المعروض للعميل
            $table->string('path');                   // المسار الفعلي
            $table->enum('type', ['video', 'zip', 'pdf', 'other'])->default('other');
            $table->unsignedBigInteger('size')->nullable(); // بالـ bytes
            $table->boolean('is_visible')->default(true);   // هل يراه العميل؟
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_files');
    }
};
