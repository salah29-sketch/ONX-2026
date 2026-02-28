<?php

namespace App\Http\Controllers;
use App\Client;
use App\Service;
use App\Employee;
use Carbon\Carbon;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;


class ReservationController extends Controller
{
  public function store(Request $request)
{
    $validated = $request->validate([
    'name'     => 'required|string|max:255',
    'email'    => 'required|email',
    'phone'    => 'required|string|max:20',
    'date'     => 'required|date',
    'services' => 'array|required',
    'services.*' => 'exists:services,id',
]);
        if ($request->event_location_id === 'other' && empty($request->custom_event_location)) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى إدخال مكان الحفل عند اختيار "مكان آخر".'
            ]);
        }

// جرّب الإيميل أولاً
try {
    $serviceNames = Service::whereIn('id', $validated['services'])->pluck('name')->toArray();
    $totalPrice = Service::whereIn('id', $validated['services'])->sum('price');

    $data = [
        'client_name' => $validated['name'],
        'booking_id'  => null,
        'email'       => $validated['email'],
        'date'        => Carbon::parse($validated['date'])->format('Y-m-d'),
        'time'        => Carbon::parse($validated['date'])->format('H:i'),
        'services'    => $serviceNames,
        'total_price' => $totalPrice,
    ];

    Mail::to($validated['email'])->send(new BookingConfirmationMail($data));

    $client = Client::firstOrCreate(
        ['email' => $validated['email']],
        ['name' => $validated['name'], 'phone' => $validated['phone']]
    );

    $randomEmployee = Employee::inRandomOrder()->first();

    $appointment = Appointment::create([
        'client_id'   => $client->id,
        'employee_id' => optional($randomEmployee)->id,
        'start_time'  => $validated['date'],
        'finish_time' => Carbon::parse($validated['date'])->addHours(4),
        'status'      => 0,
        'event_location_id' => is_numeric($request['event_location_id']) ? $request['event_location_id'] : null,
        'custom_event_location' => $request['event_location_id'] === 'other' ? $request['custom_event_location'] : null,
        'price'=>$data['total_price']
    ]);

    $appointment->services()->sync($validated['services']);

    return response()->json([
        'success' => true,
        'id' => $appointment->id
    ]);
} catch (\Exception $e) {
    Log::error("Échec d’envoi d’email: " . $e->getMessage());

    return response()->json([
        'success' => false,
        'message' => '❌ ف '.$e->getMessage()
    ]);
}

}

}

