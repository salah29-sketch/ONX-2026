<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdPackage;
use Illuminate\Http\Request;

class AdPackagesController extends Controller
{
    public function index()
    {
        $adPackages = AdPackage::orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20);

        return view('admin.adPackages.index', compact('adPackages'));
    }

    public function create()
    {
        return view('admin.adPackages.create');
    }

    public function store(Request $request)
    {
$data = $request->validate([
    'name'        => ['required', 'string', 'max:255'],
    'type'        => ['required', 'in:monthly,custom'],
    'price'       => ['nullable', 'numeric', 'min:0'],
    'old_price'   => ['nullable', 'numeric', 'min:0'],
    'price_note'  => ['nullable', 'string', 'max:255'],
    'features'    => ['nullable', 'string'],
    'subtitle'    => ['nullable', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'is_featured' => ['nullable', 'boolean'],
    'sort_order'  => ['nullable', 'integer'],
    'is_active'   => ['nullable', 'boolean'],
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
$data['price_note']  = $request->filled('price_note') ? $request->input('price_note') : null;

        AdPackage::create($data);

        return redirect()->route('admin.ad-packages.index');
    }

    public function show(AdPackage $ad_package)
    {
        $adPackage = $ad_package;

        return view('admin.adPackages.show', compact('adPackage'));
    }

    public function edit(AdPackage $ad_package)
    {
        $adPackage = $ad_package;

        return view('admin.adPackages.edit', compact('adPackage'));
    }

    public function update(Request $request, AdPackage $ad_package)
    {
        $adPackage = $ad_package;

$data = $request->validate([
    'name'        => ['required', 'string', 'max:255'],
    'type'        => ['required', 'in:monthly,custom'],
    'price'       => ['nullable', 'numeric', 'min:0'],
    'old_price'   => ['nullable', 'numeric', 'min:0'],
    'price_note'  => ['nullable', 'string', 'max:255'],
    'features'    => ['nullable', 'string'],
    'subtitle'    => ['nullable', 'string', 'max:255'],
    'description' => ['nullable', 'string'],
    'is_featured' => ['nullable', 'boolean'],
    'sort_order'  => ['nullable', 'integer'],
    'is_active'   => ['nullable', 'boolean'],
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
$data['price_note']  = $request->filled('price_note') ? $request->input('price_note') : null;

        $adPackage->update($data);

        return redirect()->route('admin.ad-packages.index');
    }

    public function destroy(AdPackage $ad_package)
    {
        $ad_package->delete();

        return back();
    }
}