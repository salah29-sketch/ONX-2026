<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('adPackages', function (Blueprint $table) {
        $table->id();

        // monthly | custom
        $table->string('type')->default('monthly');

        $table->string('name');
        $table->string('subtitle')->nullable();
        $table->text('description')->nullable();

        $table->unsignedInteger('price')->nullable();       // للباقة الشهرية
        $table->string('price_note')->nullable();           // "حسب الطلب" / "ابتداء من..."
        $table->json('features')->nullable();               // array

        $table->boolean('is_featured')->default(false);
        $table->unsignedInteger('sort_order')->default(0);
        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adPackages');
    }
}
