@props(['key', 'default' => '', 'class' => ''])

@php
    use App\EditableContent;

    $record = EditableContent::where('key', $key)->first();
    $url = $record && $record->content ? asset($record->content) : asset($default);
@endphp

<div class="editable-image-wrapper position-relative d-inline-block {{ $class }}" style="cursor: pointer; max-width: 100%;">
    <img src="{{ $url }}"
         alt="Image"
         class="img-fluid editable-image"
         data-key="{{ $key }}"
         onclick="triggerImageUpload(this)">

    {{-- إدخال ملف مخفي لرفع الصورة --}}
    <input type="file" class="image-uploader d-none" accept="image/*">

    {{-- أيقونة تحميل تظهر عند المرور --}}
    <div class="upload-icon position-absolute top-50 start-50 translate-middle text-white" style="display: none;">
        <i class="bi bi-upload" style="font-size: 2rem;"></i>
    </div>
</div>
