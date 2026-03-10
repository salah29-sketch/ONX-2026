<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;

class HomeController extends Controller
{
    public function index()
    {
        // صور عشوائية في كل زيارة — بدون تحديد يدوي
        $homeFeatured = PortfolioItem::query()
            ->where('is_active', true)
            ->where('media_type', 'image')
            ->whereNotNull('image_path')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('front.home', compact('homeFeatured'));
    }
}