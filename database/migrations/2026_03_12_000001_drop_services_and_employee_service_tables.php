<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('employee_service');
        Schema::dropIfExists('appointment_service');
        Schema::dropIfExists('services');
    }

    public function down(): void
    {
        // لا نعيد إنشاء الجداول؛ يمكن الرجوع للمigrations الأصلية إن لزم
    }
};
