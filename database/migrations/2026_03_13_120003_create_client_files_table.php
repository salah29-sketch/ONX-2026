<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جدول موحد للميديا (صور + فيديوهات) للعميل.
     * يمكن ربطه بالحجز أو استخدامه مستقلاً.
     */
    public function up(): void
    {
        Schema::create('client_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('client_id');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->string('type', 20); // image | video
            $table->string('path');
            $table->string('thumbnail_path')->nullable();
            $table->string('poster_path')->nullable(); // صورة تمثيلية للفيديو
            $table->string('label')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_files');
    }
};
