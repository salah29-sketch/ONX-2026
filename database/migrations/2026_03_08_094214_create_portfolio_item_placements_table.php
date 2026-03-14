<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_item_placements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('portfolio_item_id')
                ->constrained('portfolio_items')
                ->cascadeOnDelete();

            $table->string('placement_key', 100); // home_featured / portfolio_main / services_events ...
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['portfolio_item_id', 'placement_key'], 'portfolio_item_placement_unique');
            $table->index(['placement_key', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_item_placements');
    }
};