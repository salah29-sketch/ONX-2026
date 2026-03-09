<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioItemsController extends Controller
{
    public function index()
    {
        $items = PortfolioItem::with('placements')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20);

        return view('admin.portfolioItems.index', compact('items'));
    }

    public function create()
    {
        $placementOptions = $this->placementOptions();

        return view('admin.portfolioItems.create', compact('placementOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'service_type'  => 'nullable|in:event,ads',
            'category'      => 'nullable|string|max:100',
            'media_type'    => 'required|in:image,youtube',
            'image'         => 'nullable|image|max:5120',
            'youtube_url'   => 'nullable|string|max:500',
            'caption'       => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'client_name'   => 'nullable|string|max:255',
            'location_name' => 'nullable|string|max:255',
            'sort_order'    => 'nullable|integer|min:0',
            'published_at'  => 'nullable|date',
            'placements'    => 'nullable|array',
            'placements.*'  => 'string|max:100',
        ]);

        if ($request->input('media_type') === 'image' && !$request->hasFile('image')) {
            return back()->withErrors([
                'image' => 'الصورة مطلوبة عندما يكون نوع الوسائط صورة.',
            ])->withInput();
        }

        if ($request->input('media_type') === 'youtube' && !$request->filled('youtube_url')) {
            return back()->withErrors([
                'youtube_url' => 'رابط YouTube مطلوب عندما يكون نوع الوسائط YouTube.',
            ])->withInput();
        }

        $data = [
            'title'         => $request->title,
            'service_type'  => $request->service_type,
            'category'      => $request->category,
            'media_type'    => $request->media_type,
            'youtube_url'   => $request->youtube_url,
            'caption'       => $request->caption,
            'description'   => $request->description,
            'client_name'   => $request->client_name,
            'location_name' => $request->location_name,
            'sort_order'    => $request->sort_order ?? 0,
            'published_at'  => $request->published_at,
            'is_featured'   => $request->boolean('is_featured'),
            'is_active'     => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        if ($request->input('media_type') !== 'image') {
            $data['image_path'] = null;
        }

        $item = PortfolioItem::create($data);

        foreach ($request->input('placements', []) as $index => $placementKey) {
            $item->placements()->create([
                'placement_key' => $placementKey,
                'sort_order'    => $index,
                'is_active'     => true,
            ]);
        }

        return redirect()
            ->route('admin.portfolio-items.index')
            ->with('message', 'تم إنشاء العمل بنجاح.');
    }

    public function show(PortfolioItem $portfolioItem)
    {
        $portfolioItem->load('placements');

        return view('admin.portfolioItems.show', compact('portfolioItem'));
    }

    public function edit(PortfolioItem $portfolioItem)
    {
        $portfolioItem->load('placements');
        $placementOptions = $this->placementOptions();

        return view('admin.portfolioItems.edit', compact('portfolioItem', 'placementOptions'));
    }

    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'service_type'  => 'nullable|in:event,ads',
            'category'      => 'nullable|string|max:100',
            'media_type'    => 'required|in:image,youtube',
            'image'         => 'nullable|image|max:20120',
            'youtube_url'   => 'nullable|string|max:500',
            'caption'       => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'client_name'   => 'nullable|string|max:255',
            'location_name' => 'nullable|string|max:255',
            'sort_order'    => 'nullable|integer|min:0',
            'published_at'  => 'nullable|date',
            'placements'    => 'nullable|array',
            'placements.*'  => 'string|max:100',
        ]);

        if ($request->input('media_type') === 'image' && !$portfolioItem->image_path && !$request->hasFile('image')) {
            return back()->withErrors([
                'image' => 'الصورة مطلوبة عندما يكون نوع الوسائط صورة.',
            ])->withInput();
        }

        if ($request->input('media_type') === 'youtube' && !$request->filled('youtube_url')) {
            return back()->withErrors([
                'youtube_url' => 'رابط YouTube مطلوب عندما يكون نوع الوسائط YouTube.',
            ])->withInput();
        }

        $data = [
            'title'         => $request->title,
            'service_type'  => $request->service_type,
            'category'      => $request->category,
            'media_type'    => $request->media_type,
            'youtube_url'   => $request->youtube_url,
            'caption'       => $request->caption,
            'description'   => $request->description,
            'client_name'   => $request->client_name,
            'location_name' => $request->location_name,
            'sort_order'    => $request->sort_order ?? 0,
            'published_at'  => $request->published_at,
            'is_featured'   => $request->boolean('is_featured'),
            'is_active'     => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('portfolio', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        if ($request->input('media_type') !== 'image') {
            $data['image_path'] = null;
        }

        $portfolioItem->update($data);

        $portfolioItem->placements()->delete();

        foreach ($request->input('placements', []) as $index => $placementKey) {
            $portfolioItem->placements()->create([
                'placement_key' => $placementKey,
                'sort_order'    => $index,
                'is_active'     => true,
            ]);
        }

        return redirect()
            ->route('admin.portfolio-items.index')
            ->with('message', 'تم تحديث العمل بنجاح.');
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        if ($portfolioItem->image_path && file_exists(public_path($portfolioItem->image_path))) {
            @unlink(public_path($portfolioItem->image_path));
        }

        $portfolioItem->delete();

        return redirect()
            ->route('admin.portfolio-items.index')
            ->with('message', 'تم حذف العمل بنجاح.');
    }

    private function placementOptions(): array
    {
        return [
            'home_featured'      => 'الرئيسية - أعمال مختارة',
            'portfolio_main'     => 'صفحة الأعمال الرئيسية',
            'services_events'    => 'صفحة خدمات الحفلات',
            'services_marketing' => 'صفحة خدمات الإعلانات',
        ];
    }
}