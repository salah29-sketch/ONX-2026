<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_homes', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // العنوان مثل "Développement Web"
            $table->string('icon')->default('bi-laptop');  // أيقونة Bootstrap
            $table->text('description')->nullable();       // وصف أو تفاصيل مختصرة
            $table->json('features')->nullable();          // قائمة النقاط bullet points بصيغة JSON
            $table->string('slug')->nullable();            // للرابط مثل service-details.html
            $table->boolean('active')->default(true);      // لتفعيل/تعطيل الخدمة
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
        Schema::dropIfExists('service_homes');
    }
}
