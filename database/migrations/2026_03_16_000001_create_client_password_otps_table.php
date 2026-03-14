<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_password_otps', function (Blueprint $table) {
            $table->id();
            // البريد الإلكتروني للعميل (المعرّف المستخدم في الطلب)
            $table->string('email')->index();
            // الكود المشفّر (6 أرقام)
            $table->string('code');
            // منتهي الصلاحية بعد 10 دقائق
            $table->timestamp('expires_at');
            // عدد محاولات الإدخال الخاطئة (للحماية من Brute Force)
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_password_otps');
    }
};