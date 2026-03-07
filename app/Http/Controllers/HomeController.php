<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Service;
use App\Models\EventLocation;
use App\Models\EventPackage;
use App\Models\AdPackage;

class HomeController extends Controller
{
    public function index()
    {
    return view('front.home');
    }
    public function booking(): View
    {
        // الخدمات (checkbox)
        $services = Service::all()->mapWithKeys(function ($s) {
            return [
                $s->id => [
                    'name'  => $s->name,
                    'price' => (float) $s->price,
                ]
            ];
        });

        // أماكن الحفلات
        $event_locations = EventLocation::all();
        // باقات الحفلات من DB
        $eventPackages = EventPackage::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        // باقات الإعلانات من DB (monthly/custom)
        $adMonthly = AdPackage::where('is_active', true)
            ->where('type', 'monthly')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $adCustom = AdPackage::where('is_active', true)
            ->where('type', 'custom')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        return view('booking.index', compact(
            'services',
            'event_locations',
            'eventPackages',
            'adMonthly',
            'adCustom'
        ));
    }
}