<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ClientService;
use App\Services\AppointmentService;


class ReservationController extends Controller
{
    public function __construct(
        private ClientService $clientService,
        private AppointmentService $appointmentService,
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            ‘name’                  => ‘required|string|max:255’,
            ‘email’                 => ‘required|email|max:255’,
            ‘phone’                 => ‘required|string|max:20’,
            ‘date’                  => ‘required|date’,
            ‘services’              => ‘required|array’,
            ‘services.*’            => ‘exists:services,id’,
            ‘event_location_id’     => ‘nullable|string’,
            ‘custom_event_location’ => ‘required_if:event_location_id,other|nullable|string|max:255’,
        ]);

        try {
            $services   = Service::whereIn(‘id’, $validated[‘services’])->select(‘id’, ‘name’, ‘price’)->get();
            $totalPrice = $services->sum(‘price’);

            $client = $this->clientService->findOrCreate([
                ‘email’ => $validated[‘email’],
                ‘name’  => $validated[‘name’],
                ‘phone’ => $validated[‘phone’],
            ]);

            $appointmentData = array_merge($validated, [
                ‘total_price’ => $totalPrice,
            ]);

            $appointment = $this->appointmentService->createFromBooking($appointmentData, $client->id);

            $mailData = [
                ‘client_name’ => $validated[‘name’],
                ‘booking_id’  => $appointment->id,
                ‘email’       => $validated[‘email’],
                ‘date’        => Carbon::parse($validated[‘date’])->format(‘Y-m-d’),
                ‘time’        => Carbon::parse($validated[‘date’])->format(‘H:i’),
                ‘services’    => $services->pluck(‘name’)->toArray(),
                ‘total_price’ => $totalPrice,
            ];

            $this->appointmentService->sendConfirmationEmail($mailData);

            return response()->json([
                ‘success’ => true,
                ‘id’      => $appointment->id,
            ]);

        } catch (\Exception $e) {
            Log::error(‘خطأ في إنشاء الحجز: ‘ . $e->getMessage());

            return response()->json([
                ‘success’ => false,
                ‘message’ => ‘حدث خطأ أثناء معالجة طلبك. يرجى المحاولة مرة أخرى.’,
            ], 500);
        }
    }
}

