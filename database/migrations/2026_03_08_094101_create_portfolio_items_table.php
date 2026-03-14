<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique()->nullable();

            $table->string('service_type', 50)->nullable(); // event / marketing
            $table->string('category', 100)->nullable();    // wedding / restaurant / brand / ...

            $table->string('media_type', 30)->default('image'); // image / youtube

            $table->string('image_path')->nullable();

            $table->string('youtube_url')->nullable();
            $table->string('youtube_video_id', 100)->nullable();

            $table->string('caption')->nullable();
            $table->text('description')->nullable();

            $table->string('client_name')->nullable();
            $table->string('location_name')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index(['service_type', 'is_active']);
            $table->index(['media_type', 'is_active']);
            $table->index(['is_featured', 'is_active']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};