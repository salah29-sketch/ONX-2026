<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventLocation;
use Illuminate\Http\Request;

class EventLocationController extends Controller
{
    public function index()
    {
        $locations = EventLocation::latest()->get();

        return view('admin.event-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.event-locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        EventLocation::create([
            'name'    => $request->name,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('admin.eventlocations.index')
            ->with('success', 'تم إنشاء المكان بنجاح');
    }

    public function edit(EventLocation $eventlocation)
    {
        return view('admin.event-locations.edit', compact('eventlocation'));
    }

    public function update(Request $request, EventLocation $eventlocation)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $eventlocation->update([
            'name'    => $request->name,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('admin.eventlocations.index')
            ->with('success', 'تم تحديث المكان بنجاح');
    }

    public function destroy(EventLocation $eventlocation)
    {
        $eventlocation->delete();

        return redirect()
            ->route('admin.eventlocations.index')
            ->with('success', 'تم حذف المكان بنجاح');
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            EventLocation::whereIn('id', $ids)->delete();
        }

        return redirect()
            ->route('admin.eventlocations.index')
            ->with('success', 'تم حذف الأماكن المحددة');
    }
}