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

        $featuredItems = (clone $baseQuery)
            ->where('is_featured', true)
            ->take(3)
            ->get();

        $items = (clone $baseQuery)->get();

        return view('front.portfolio', [
            'items'         => $items,
            'featuredItems' => $featuredItems,
            'categories'    => $this->categories,
        ]);
    }
}