<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('client')->check()) {
            return redirect()->route('client.dashboard');
        }
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required',
        ], [
            'login.required'    => 'أدخل البريد الإلكتروني أو رقم الهاتف.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        $client = Client::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->first();

        if (!$client || !$client->password || !Hash::check($request->password, $client->password)) {
            return back()->withErrors(['login' => 'بيانات الدخول غير صحيحة.'])->withInput();
        }
        if ($client->login_disabled) {
            return back()->withErrors(['login' => 'تم تعطيل دخول هذا الحساب من الإدارة.'])->withInput();
        }

        Auth::guard('client')->login($client, $request->boolean('remember'));
        return redirect()->intended(route('client.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login');
    }

    /** عرض نموذج ضبط كلمة المرور (بعد الحجز إذا لم يكن لديه حساب) */
    public function showSetPassword(\App\Models\Booking $booking)
    {
        if (!$booking->client_id) {
            return redirect()->route('booking.confirmation', $booking)->withErrors(['msg' => 'لا يوجد عميل مرتبط بهذا الحجز.']);
        }
        $client = $booking->client;
        if ($client->password) {
            return redirect()->route('client.login')->with('message', 'لديك حساب مسبقاً. سجّل الدخول.');
        }
        return view('client.auth.set-password', compact('booking', 'client'));
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $booking = \App\Models\Booking::findOrFail($request->booking_id);
        $client = $booking->client;
        if (!$client) {
            return back()->withErrors(['msg' => 'لا يوجد عميل مرتبط.']);
        }
        if ($client->password) {
            return redirect()->route('client.login')->with('message', 'تم ضبط كلمة المرور مسبقاً.');
        }

        $client->password = $request->password;
        $client->save();

        Auth::guard('client')->login($client);
        return redirect()->route('client.dashboard')->with('success', 'تم إنشاء كلمة المرور. يمكنك الآن متابعة طلباتك من هنا.');
    }
}
