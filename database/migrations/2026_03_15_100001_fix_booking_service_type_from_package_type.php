<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * تصحيح service_type للحجوزات التي تكون فارغة أو غير صحيحة، حسب package_type
     */
    public function up(): void
    {
        $rows = DB::table('bookings')
            ->whereNotNull('package_type')
            ->where(function ($q) {
                $q->whereNull('service_type')
                  ->orWhere('service_type', '');
            })
            ->get();

        foreach ($rows as $b) {
            $pt = $b->package_type ?? '';
            $newType = null;
            if (in_array($pt, ['event', 'App\\Models\\EventPackage'], true) || stripos($pt, 'Event') !== false) {
                $newType = 'event';
            } elseif (in_array($pt, ['ads', 'App\\Models\\AdPackage'], true) || stripos($pt, 'Ad') !== false) {
                $newType = 'ads';
            }
            if ($newType) {
                DB::table('bookings')->where('id', $b->id)->update(['service_type' => $newType]);
            }
        }

        // تصحيح: إن كان package_id موجوداً في ad_packages لكن service_type = 'event' → نضبط service_type = 'ads'
        $adPackageIds = DB::table('ad_packages')->pluck('id')->toArray();
        if (!empty($adPackageIds)) {
            DB::table('bookings')
                ->where('service_type', 'event')
                ->whereIn('package_id', $adPackageIds)
                ->update(['service_type' => 'ads']);
        }
    }

    public function down(): void
    {
        //
    }
};
