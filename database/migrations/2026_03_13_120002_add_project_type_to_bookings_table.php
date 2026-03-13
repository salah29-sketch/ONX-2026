<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تصنيف المشروع: حفلات / إعلانات / تسويق / مشاريع شخصية
     * يسهل الفلترة في لوحة التحكم والواجهة (يمكن تركه null واستخدام service_type)
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('project_type', 50)->nullable()->after('service_type');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('project_type');
        });
    }
};
