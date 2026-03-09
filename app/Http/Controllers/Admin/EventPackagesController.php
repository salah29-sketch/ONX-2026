<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventPackage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventPackagesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = EventPackage::query()->select(sprintf('%s.*', (new EventPackage)->getTable()));
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = null;
                $editGate = null;
                $deleteGate = null;
                $crudRoutePart = 'event-packages';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', fn ($row) => $row->id ?? '');
            $table->editColumn('name', fn ($row) => $row->name ?? '');
            $table->editColumn('subtitle', fn ($row) => $row->subtitle ?? '');
            $table->editColumn('price', fn ($row) => $row->price !== null ? number_format((float) $row->price, 0) . ' DA' : '');
            $table->editColumn('old_price', fn ($row) => $row->old_price !== null ? number_format((float) $row->old_price, 0) . ' DA' : '');
            $table->editColumn('is_featured', fn ($row) => $row->is_featured ? 'Yes' : 'No');
            $table->editColumn('is_active', fn ($row) => $row->is_active ? 'Yes' : 'No');
            $table->editColumn('sort_order', fn ($row) => $row->sort_order ?? 0);

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.eventPackages.index');
    }

    public function create()
    {
        return view('admin.eventPackages.create');
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

        return view('admin.eventPackages.edit', compact('eventPackage'));
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

        return view('admin.eventPackages.show', compact('eventPackage'));
    }

    public function destroy(EventPackage $event_package)
    {
        $event_package->delete();

        return back();
    }
}