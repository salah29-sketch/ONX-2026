<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('category');
        $query = GalleryItem::query();

        if ($filter) {
            $query->where('category', $filter);
        }

        $items = $query->latest()->paginate(12);

        if ($request->ajax()) {
            return view('admin.partials.gallery-items', compact('items'))->render();
        }

        $categories = ['wedding' => 'زفاف', 'engagement' => 'خطوبة', 'baby' => 'أطفال', 'event' => 'مناسبات'];
        $data =['data'=>'starter'];

        return view('admin.gallery', compact('items', 'categories', 'filter','data'));

    }

 public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:2048',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string',
    ]);

    $path = $request->file('image')->store('gallery', 'public');

    $item = GalleryItem::create([
        'title' => $request->title,
        'description' => $request->description,
        'category' => $request->category,
        'image_path' => 'storage/' . $path,
    ]);

    // إذا كان الطلب عبر AJAX، أرجع JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'item' => $item,
        ]);
    }

    // إذا كان طلب عادي (ليس AJAX)
    return redirect()->route('admin.gallery.index')->with('success', 'تمت إضافة الصورة.');
}

    public function destroy($id)
    {
        $item = GalleryItem::findOrFail($id);
        if ($item->image_path && file_exists(public_path($item->image_path))) {
            unlink(public_path($item->image_path));
        }
        $item->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'تم حذف الصورة.');
    }

    public function toggleHome($id)
        {
            $item = GalleryItem::findOrFail($id);
            $item->show_in_homepage = !$item->show_in_homepage;
            $item->save();

            return back()->with('success', 'تم تحديث حالة العرض في الصفحة الرئيسية.');
        }
}

