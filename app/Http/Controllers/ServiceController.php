<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\EventPackage;
use App\Models\Adpackage;
use App\Models\PortfolioItem;

class ServiceController extends Controller
{
    /**
     * صفحة /services
     */
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

        return view('services.index', compact('services'));
    }

    /**
     * صفحة /services/events
     * يجعل featured في الوسط
     */
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

        $PackagesOrdered = collect();
        $PackagesOrdered = $PackagesOrdered->merge($before);

        if ($featured) {
            $PackagesOrdered->push($featured);
        }

        $PackagesOrdered = $PackagesOrdered->merge($after);

        $travelNote = 'خارج ولاية سيدي بلعباس: تُضاف رسوم تنقل حسب الولاية.';

        $eventWorks = PortfolioItem::query()
            ->where('is_active', true)
            ->where('service_type', 'event')
            ->whereHas('placements', function ($q) {
                $q->where('placement_key', 'services_events')
                  ->where('is_active', true);
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        return view('services.events', [
            'Packages'   => $PackagesOrdered,
            'travelNote' => $travelNote,
            'eventWorks' => $eventWorks,
        ]);
    }

    /**
     * صفحة /services/marketing
     * كل المحتوى من DB (monthly + custom)
     */
    public function marketing(): View
    {
        $monthly = Adpackage::where('is_active', true)
            ->where('type', 'monthly')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $custom = Adpackage::where('is_active', true)
            ->where('type', 'custom')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $marketingWorks = PortfolioItem::query()
            ->where('is_active', true)
            ->where('service_type', 'ads')
            ->whereHas('placements', function ($q) {
                $q->where('placement_key', 'services_marketing')
                  ->where('is_active', true);
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        return view('services.marketing', compact('monthly', 'custom', 'marketingWorks'));
    }
}