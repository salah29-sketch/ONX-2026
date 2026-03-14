<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event\EventPackage;
use Illuminate\Http\Request;

class EventPackagesController extends Controller
{
    public function index()
    {
        $eventPackages = EventPackage::orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20);

        return view('admin.event-packages.index', compact('eventPackages'));
    }

    public function create()
    {
        return view('admin.event-packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            'features'    => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $featuresLines = array_values(array_filter(array_map(
            'trim',
            preg_split("/\r\n|\n|\r/", $data['features'] ?? '')
        )));
        $data['features'] = $featuresLines;

        $data['is_featured'] = (bool) $request->input('is_featured', false);
        $data['is_active']   = (bool) $request->input('is_active', true);
        $data['sort_order']  = (int) $request->input('sort_order', 0);
        $data['price']       = $request->filled('price') ? $request->input('price') : null;
        $data['old_price']   = $request->filled('old_price') ? $request->input('old_price') : null;

        if ($data['is_featured']) {
            EventPackage::where('is_featured', true)->update(['is_featured' => false]);
        }

        EventPackage::create($data);

        return redirect()->route('admin.event-packages.index');
    }

    public function edit(EventPackage $event_package)
    {
        $eventPackage = $event_package;

        return view('admin.event-packages.edit', compact('eventPackage'));
    }

    public function update(Request $request, EventPackage $event_package)
    {
        $eventPackage = $event_package;

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'old_price'   => 'nullable|numeric|min:0',
            'features'    => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        $featuresLines = array_values(array_filter(array_map(
            'trim',
            preg_split("/\r\n|\n|\r/", $data['features'] ?? '')
        )));
        $data['features'] = $featuresLines;

        $data['is_featured'] = (bool) $request->input('is_featured', false);
        $data['is_active']   = (bool) $request->input('is_active', true);
        $data['sort_order']  = (int) $request->input('sort_order', 0);
        $data['price']       = $request->filled('price') ? $request->input('price') : null;
        $data['old_price']   = $request->filled('old_price') ? $request->input('old_price') : null;

        if ($data['is_featured']) {
            EventPackage::where('is_featured', true)
                ->where('id', '!=', $eventPackage->id)
                ->update(['is_featured' => false]);
        }

        $eventPackage->update($data);

        return redirect()->route('admin.event-packages.index');
    }

    public function show(EventPackage $event_package)
    {
        $eventPackage = $event_package;

        return view('admin.event-packages.show', compact('eventPackage'));
    }

    public function destroy(EventPackage $event_package)
    {
        $event_package->delete();

        return back();
    }
}