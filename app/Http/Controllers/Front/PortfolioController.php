<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    private array $categories = [
        'event' => 'الفعاليات',
        'ads'   => 'الإعلانات',
    ];

    public function index(Request $request)
    {
        $baseQuery = PortfolioItem::query()
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id');

        // الصورة المميزة في الـ hero — ثابتة دائماً
        $heroItem = PortfolioItem::where('is_featured', true)
            ->where('is_active', true)
            ->first();

        // أعمال مختارة — 3 صور عشوائية في كل زيارة (صور فقط، بدون يوتيوب)
        $featuredItems = PortfolioItem::where('is_active', true)
            ->where('media_type', 'image')
            ->whereNotNull('image_path')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $items = (clone $baseQuery)->get();

        return view('front.portfolio', [
            'items'         => $items,
            'featuredItems' => $featuredItems,
            'heroItem'      => $heroItem,
            'categories'    => $this->categories,
        ]);
    }
}