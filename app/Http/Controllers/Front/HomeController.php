<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
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
}
