<?php

namespace App\Services;

use App\Models\Booking\Booking;
use App\Models\Client\Client;
use App\Models\Event\EventPackage;
use App\Models\Event\AdPackage;
use App\Models\Event\EventLocation;
use App\Models\Subscription\Subscription;
use Carbon\Carbon;

class BookingService
{
    /**
     * التحقق من حالة تاريخ الحجز
     */
    public function getDateStatus(string $date): array
    {
        $bookings = Booking::where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->get();

        foreach ($bookings as $booking) {
            if (in_array($booking->status, ['confirmed', 'in_progress', 'completed'], true)) {
                return [
                    'status'  => 'booked',
                    'message' => '🔴 هذا اليوم محجوز ومؤكد',
                ];
            }

            if ($booking->status === 'unconfirmed') {
                return [
                    'status'  => 'pending',
                    'message' => '🟠 هذا اليوم محجوز وغير مؤكد',
                ];
            }
        }

        return [
            'status'  => 'available',
            'message' => '✅ هذا اليوم متاح',
        ];
    }

    /**
     * إيجاد أو إنشاء العميل عند الحجز
     */
    public function findOrCreateClient(array $data): Client
    {
        $phone = trim((string) ($data['phone'] ?? ''));
        $email = isset($data['email']) ? trim((string) $data['email']) : null;
        $name  = trim((string) ($data['name'] ?? ''));
        if ($name === '') {
            $name = $phone ?: $email ?: 'عميل';
        }

        $client = $phone ? Client::where('phone', $phone)->first() : null;
        if (!$client && $email) {
            $client = Client::where('email', $email)->first();
        }

        $isCompany    = !empty($data['is_company']);
        $businessName = trim((string) ($data['business_name'] ?? '')) ?: null;

        if (!$client) {
            $client = Client::create([
                'name'          => $name,
                'phone'         => $phone ?: null,
                'email'         => $email ?: null,
                'is_company'    => $isCompany,
                'business_name' => $businessName,
            ]);
        } else {
            $update = [
                'name'  => $name,
                'phone' => $phone ?: $client->phone,
                'email' => $email ?? $client->email,
            ];
            if ($isCompany) {
                $update['is_company']    = true;
                $update['business_name'] = $businessName ?? $client->business_name;
            }
            $client->update($update);
        }

        return $client;
    }

    /**
     * إنشاء الحجز بعد التحقق
     * للاشتراكات الشهرية: يُضبط total_price من الباقة ويُنشأ سجل اشتراك
     */
    public function createBooking(array $data, Client $client): Booking
    {
        $data['client_id'] = $client->id;
        $data['status']    = 'unconfirmed';

        // للاشتراك الشهري: السعر من الباقة (لا حقل ميزانية من العميل)
        if (($data['service_type'] ?? '') === 'ads' && ($data['ads_type'] ?? '') === 'monthly') {
            $adPackage = AdPackage::find($data['package_id'] ?? 0);
            if ($adPackage && $adPackage->type === 'monthly' && $adPackage->price !== null) {
                $data['total_price'] = $adPackage->price;
            }
        }

        $booking = Booking::create($data);

        // إنشاء سجل الاشتراك الشهري: يبدأ من تاريخ اختيار العميل
        if ($booking->isMonthlySubscription() && $booking->event_date) {
            $startDate = Carbon::parse($booking->event_date);
            $nextBilling = $startDate->copy()->addMonth();
            Subscription::create([
                'client_id'         => $client->id,
                'booking_id'        => $booking->id,
                'ad_package_id'     => $booking->package_id,
                'start_date'        => $startDate,
                'next_billing_date' => $nextBilling,
                'renewal_type'     => 'manual',
                'status'            => 'active',
            ]);
        }

        return $booking;
    }

    /**
     * جلب بيانات الباقة والموقع لصفحة التأكيد والـ PDF
     *
     * الإصلاح: نتحقق أن الباقة موجودة فعلاً في الجدول الصحيح.
     * إذا كان service_type = 'ads' لكن package_id يشير لباقة حفل → لا نعرضها.
     */
    public function getBookingMeta(Booking $booking): array
    {
        $packageName  = null;
        $packagePrice = null;
        $package      = null;

        if ($booking->package_id) {
            if ($booking->service_type === 'event') {
                // نبحث فقط في event_packages
                $candidate = EventPackage::find($booking->package_id);
                if ($candidate) {
                    $package      = $candidate;
                    $packageName  = $candidate->name;
                    $packagePrice = $candidate->price;
                }
                // إذا لم يُوجد في event_packages → الباقة غير صحيحة، نتركها فارغة

            } elseif ($booking->service_type === 'ads') {
                // نبحث فقط في ad_packages
                $candidate = AdPackage::find($booking->package_id);
                if ($candidate) {
                    $package      = $candidate;
                    $packageName  = $candidate->name;
                    $packagePrice = $candidate->price ?? $candidate->price_note;
                }
                // إذا لم يُوجد في ad_packages → الباقة غير صحيحة، نتركها فارغة
                // هذا يمنع ظهور باقة حفلات بدل باقة إعلانات
            }
        }

        $locationName = null;

        if (!empty($booking->custom_event_location)) {
            $locationName = $booking->custom_event_location;
        } elseif (!empty($booking->event_location_id) && $booking->event_location_id !== 'other') {
            $location     = EventLocation::find($booking->event_location_id);
            $locationName = $location ? $location->name : null;
        }

        return [
            'packageName'  => $packageName,
            'packagePrice' => $packagePrice,
            'package'      => $package,
            'locationName' => $locationName,
        ];
    }

    /**
     * التحقق من أن التاريخ غير محجوز مسبقاً (عند التعديل من Admin)
     */
    public function isDateTakenForUpdate(string $date, int $excludeBookingId): bool
    {
        return Booking::where('id', '!=', $excludeBookingId)
            ->where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress'])
            ->exists();
    }

    /**
     * التحقق من أن التاريخ غير محجوز مسبقاً (عند الحجز الجديد)
     */
    public function isDateTaken(string $date): bool
    {
        return Booking::where('service_type', 'event')
            ->whereDate('event_date', $date)
            ->whereIn('status', ['unconfirmed', 'confirmed', 'in_progress'])
            ->exists();
    }
}