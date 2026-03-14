<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('ad_packages', function (Blueprint $table) {
            $table->id();

            // monthly | custom
            $table->string('type')->default('monthly');

            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->string('price_note')->nullable(); // مثل: حسب الطلب / ابتداء من...
            $table->json('features')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ad_packages');
    }
}