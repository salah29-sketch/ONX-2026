<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\EventPackage;
use App\Models\Adpackage;

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
     * ✅ يجعل featured في الوسط حتى لو صار عندك 5+ باقات
     */
    public function events(): View
    {
        $all = EventPackage::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->get();

        $featured = $all->firstWhere('is_featured', true);
        $others   = $all->where('is_featured', false)->values();

        // نقسم الآخرين إلى نصفين ثم نضع featured في الوسط
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

        return view('services.events', [
            'Packages'   => $PackagesOrdered,
            'travelNote' => $travelNote,
        ]);
    }

    /**
     * صفحة /services/marketing
     * ✅ كل المحتوى من DB (monthly + custom)
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

        return view('services.marketing', compact('monthly', 'custom'));
    }
}
