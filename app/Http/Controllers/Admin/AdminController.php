<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use App\GalleryItem;
use App\HomeContent;
use App\ServiceHome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
      public function edit(Request $request)
    {

          $referer = $request->headers->get('referer');

            if (!$referer || !str_contains($referer, route('admin.home'))) {
                abort(403, '❌ غير مسموح بالوصول المباشر.');
            }


         $content = HomeContent::first();
         $services = ServiceHome::all();
         $homepageImages = GalleryItem::where('show_in_homepage', true)->latest()->take(12)->get();

         $className = 'index';

        return view('admin.home',[ 'content' => $content,
                                     'data' => 'main-index','services'=>$services , 'homepageImages'=>$homepageImages ]);
    }

  public function update(Request $request)
{
    // التحقق من وجود الخدمة
    $service = ServiceHome::findOrFail($request->input('id'));

    // التحقق من صحة البيانات
    $request->validate([
        'title' => 'required|string|max:255',
        'features' => 'nullable|string',
    ]);

    // تجهيز البيانات
    $data = $request->only(['title', 'description', 'features']);

    // تحويل features من نص إلى مصفوفة
    if (!empty($data['features'])) {
        $data['features'] = json_encode(array_filter(array_map('trim', explode("\n", $data['features']))));
    } else {
        $data['features'] = [];
    }

    try {
        $service->update($data);

        return response()->json([
            'success' => true,
            'message' => '✅ Le service a été mis à jour avec succès.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => '❌ Une erreur est survenue: ' . $e->getMessage(),
        ], 500);
    }
}


    public function updateInline(Request $request)
        {
                    $field = $request->input('field'); // مثل title أو description
                    $value = $request->input('value');

                    $content = HomeContent::first();
                    if (in_array($field, ['title', 'description'])) {
                        $content->$field = $value;
                        $content->save();
                    }
                    return back()->with('success', 'تم تحديث المحتوى!');
        }

}
