<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocaleToEditableContentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('editable_contents', 'locale')) {

            Schema::table('editable_contents', function (Blueprint $table) {
                $table->string('locale')->default('fr');
            });

            // إضافة unique index
            try {
                Schema::table('editable_contents', function (Blueprint $table) {
                    $table->unique(['key', 'locale']);
                });
            } catch (\Throwable $e) {
                // إذا كان موجود مسبقًا لا يحدث خطأ
            }
        }
    }

    public function down()
    {
        if (Schema::hasColumn('editable_contents', 'locale')) {

            try {
                Schema::table('editable_contents', function (Blueprint $table) {
                    $table->dropUnique(['key', 'locale']);
                });
            } catch (\Throwable $e) {}

            Schema::table('editable_contents', function (Blueprint $table) {
                $table->dropColumn('locale');
            });
        }
    }
}