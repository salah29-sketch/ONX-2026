<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\EventPackage;

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
                'route' => route('services.ads'),
            ],
        ];

        return view('services.index', compact('services'));
    }

    public function events(): View
{
    $packages = EventPackage::where('is_active', true)->get();

    $featured = $packages->where('is_featured', true)->first();

    $others = $packages->where('is_featured', false);

    // ترتيب: نصف قبل الـfeatured ونصف بعده
    $before = $others->take(ceil($others->count()/2));
    $after  = $others->slice(ceil($others->count()/2));

    $packagesOrdered = $before
        ->merge($featured ? [$featured] : [])
        ->merge($after);

    $travelNote = 'خارج ولاية سيدي بلعباس: تُضاف رسوم تنقل حسب الولاية.';

    return view('services.events', [
        'packages' => $packagesOrdered,
        'travelNote' => $travelNote
    ]);
}

    public function ads(): View
    {
        $oneTime = [
            [
                'name' => 'إعلان مرة واحدة',
                'price_note' => 'حسب الطلب',
                'features' => ['تصوير احترافي', 'مونتاج', 'مناسب للمنتجات والخدمات'],
            ],
        ];

        $monthly = [
            [
                'name' => 'اشتراك شهري Starter',
                'price' => 25000,
                'features' => ['عدد فيديوهات شهري', 'جلسة تصوير', 'تعديلات محدودة'],
                'featured' => true,
            ],
            [
                'name' => 'اشتراك شهري Pro',
                'price' => 40000,
                'features' => ['عدد أكبر من الفيديوهات', 'أولوية في التسليم', 'تعديلات أكثر'],
                'featured' => false,
            ],
        ];

        return view('services.ads', compact('oneTime', 'monthly'));
    }
}