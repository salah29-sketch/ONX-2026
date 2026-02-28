<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditableContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editable_contents', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // مثل: hero_title, hero_box_1 ...
        $table->text('content')->nullable(); // المحتوى القابل للتعديل
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
        Schema::dropIfExists('editable_contents');
    }
}
