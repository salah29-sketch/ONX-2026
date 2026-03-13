<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event\EventPackage;
use App\Models\Event\AdPackage;
use App\Models\Content\PortfolioItem;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = [
            [
                'title' => 'تصوير الحفلات',
                'desc'  => 'باقات ثابتة لتوثيق حفلاتكم بجودة سينمائية.',
                'route' => route('services.events'),
            ],
            [
                'title' => 'الإعلانات',
                'desc'  => 'إعلانات احترافية + اشتراكات شهرية للمشاريع.',
                'route' => route('services.marketing'),
            ],
        ];

        return view('front.services.index', compact('services'));
    }

   public function events(): View
{
    $all = EventPackage::where('is_active', true)
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->get();
 
    $featured = $all->firstWhere('is_featured', true);
    $others   = $all->where('is_featured', false)->values();
 
    $half   = (int) ceil($others->count() / 2);
    $before = $others->slice(0, $half);
    $after  = $others->slice($half);
 
    $PackagesOrdered = collect()
        ->merge($before)
        ->when($featured, fn($c) => $c->push($featured))
        ->merge($after);
 
    $travelNote = 'خارج ولاية سيدي بلعباس: تُضاف رسوم تنقل حسب الولاية.';
 
    $eventWorks = PortfolioItem::query()
        ->where('is_active', true)
        ->where('service_type', 'event')
        ->where('media_type', 'image')
        ->whereNotNull('image_path')
        ->inRandomOrder()
        ->limit(6)
        ->get();
 
    // ── جمع كل المميزات الفريدة من جميع الباقات ──
    $allFeatures = $PackagesOrdered->flatMap(function ($pkg) {
        $f = $pkg->features;
        return is_array($f) ? $f : (json_decode($f, true) ?? []);
    })->unique()->values()->toArray();
 
    return view('front.services.events', [
        'Packages'    => $PackagesOrdered,
        'travelNote'  => $travelNote,
        'eventWorks'  => $eventWorks,
        'allFeatures' => $allFeatures,
    ]);
}
 
public function marketing(): View
{
    $monthly = AdPackage::where('is_active', true)
        ->where('type', 'monthly')
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->get();
 
    $custom = AdPackage::where('is_active', true)
        ->where('type', 'custom')
        ->orderByDesc('is_featured')
        ->orderBy('sort_order')
        ->get();
 
    $marketingWorks = PortfolioItem::query()
        ->where('is_active', true)
        ->where('service_type', 'ads')
        ->where('media_type', 'image')
        ->whereNotNull('image_path')
        ->inRandomOrder()
        ->limit(3)
        ->get();
 
    // ── جمع كل المميزات الفريدة (شهري + مخصص منفصلين) ──
    $allMonthlyFeatures = $monthly->flatMap(function ($pkg) {
        $f = $pkg->features;
        return is_array($f) ? $f : (json_decode($f, true) ?? []);
    })->unique()->values()->toArray();
 
    $allCustomFeatures = $custom->flatMap(function ($pkg) {
        $f = $pkg->features;
        return is_array($f) ? $f : (json_decode($f, true) ?? []);
    })->unique()->values()->toArray();
 
    return view('front.services.marketing', compact(
        'monthly', 'custom', 'marketingWorks',
        'allMonthlyFeatures', 'allCustomFeatures'
    ));
}}