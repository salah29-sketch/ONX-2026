<?php

namespace App\Http\Controllers\Admin;

use App\EditableContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EditableContentController extends Controller
{


 public function update(Request $request)
{
    try {
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string',
            'locale' => 'nullable|string',
        ]);

        $key = $request->input('key');
        $value = $request->input('value');
        $locale = $request->input('locale', app()->getLocale());

       EditableContent::updateOrCreate(
            ['key' => $key, 'locale' => $locale],
            ['content' => $value]
        );

        return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح.']);

    } catch (\Throwable $e) {
        Log::error('خطأ في التحديث: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ أثناء عملية الحفظ',
        ], 500);
    }
}


    public static function getText($key, $default = '', $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $record = EditableContent::where('key', $key)->where('locale', $locale)->first();

        return $record ? $record->content : $default;
    }

 public function uploadImage(Request $request)
{
     try {

    $request->validate([
        'image' => 'required|image|max:2048',
        'key' => 'required|string',
    ]);

    $file = $request->file('image');
    $path = $file->store('images', 'public');
    $url = Storage::url($path); // يعيد /storage/images/xxx.jpg

    // حفظ الرابط في editable_contents
    EditableContent::updateOrCreate(
        ['key' => $request->key],
        ['content' => ltrim($url, '/')]
    );

    return response()->json([
        'success' => true,
        'url' => asset($url)
    ]);
      } catch (\Throwable $e) {
        Log::error('خطأ في التحديث: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ أثناء عملية الحفظ',
        ], 500);
    }
}

}
