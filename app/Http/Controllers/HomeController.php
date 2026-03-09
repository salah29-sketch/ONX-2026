<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Service;
use App\Models\EventLocation;
use App\Models\EventPackage;
use App\Models\Adpackage;
use App\Models\PortfolioItem;

class HomeController extends Controller
{
    public function index()
    {
        $homeFeatured = PortfolioItem::query()
            ->where('is_active', true)
            ->whereHas('placements', function ($q) {
                $q->where('placement_key', 'home_featured')
                  ->where('is_active', true);
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        return view('front.home', compact('homeFeatured'));
    }

    public function booking(): View
    {
        $services = Service::all()->mapWithKeys(function ($s) {
            return [
                $s->id => [
                    'name'  => $s->name,
                    'price' => (float) $s->price,
                ]
            ];
        });

        $event_locations = EventLocation::all();

        $eventPackages = EventPackage::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $adMonthly = Adpackage::where('is_active', true)
            ->where('type', 'monthly')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $adCustom = Adpackage::where('is_active', true)
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
    public function portfolio(Request $request)
{
    $filter      = $request->query('category');
    $serviceType = $request->query('service_type');

    $query = \App\Models\PortfolioItem::where('is_active', true);

    if ($filter) {
        $query->where('category', $filter);
    }

    if ($serviceType) {
        $query->where('service_type', $serviceType);
    }

    $items = $query->orderBy('sort_order')->latest()->paginate(12);

    $categories = [
        'wedding'    => 'زفاف',
        'engagement' => 'خطوبة',
        'baby'       => 'أطفال',
        'event'      => 'مناسبات',
        'ads'        => 'إعلانات',
    ];

    if ($request->ajax()) {
        return response()->json([
            'html'    => view('partials._portfolio_items', compact('items', 'categories'))->render(),
            'hasMore' => $items->hasMorePages(),
        ]);
    }

    return view('front.portfolio', compact('items', 'categories', 'filter'));
}
}