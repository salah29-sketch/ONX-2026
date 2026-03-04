<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventLocationIdToAppointmentsTable extends Migration
{
    public function up()
    {
        // 1) إضافة العمود فقط إذا غير موجود
        if (!Schema::hasColumn('appointments', 'event_location_id')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->unsignedBigInteger('event_location_id')->nullable()->after('employee_id');
            });
        }

        // 2) إضافة الـFK فقط إذا العمود موجود (ولم نضف FK من قبل)
        // اسم الكونسترينت الافتراضي غالبًا: appointments_event_location_id_foreign
        Schema::table('appointments', function (Blueprint $table) {
            // ملاحظة: dropForeign يحتاج الاسم، فنستعمل نفس الاسم الافتراضي هنا
            // إذا كان موجود مسبقًا، في migrate سيعطي خطأ، لذلك نمنعه بمحاولة بسيطة:
        });

        // طريقة آمنة بدون تعقيد: لا تضف FK إذا العمود موجود مسبقًا غالبًا FK موجود.
        // لكن لو تريد إضافة FK حتى لو العمود موجود بدون FK، نستخدم try/catch:
        try {
            Schema::table('appointments', function (Blueprint $table) {
                $table->foreign('event_location_id')
                    ->references('id')
                    ->on('event_locations')
                    ->onDelete('set null');
            });
        } catch (\Throwable $e) {
            // تجاهل إذا كان الـFK موجود مسبقًا
        }
    }

    public function down()
    {
        // حذف FK ثم العمود (إذا موجودين)
        try {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropForeign(['event_location_id']);
            });
        } catch (\Throwable $e) {
            // تجاهل إذا لم يكن موجود
        }

        if (Schema::hasColumn('appointments', 'event_location_id')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('event_location_id');
            });
        }
    }
}