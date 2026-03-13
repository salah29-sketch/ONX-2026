@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تعديل العمل</h1>
        <div class="db-page-subtitle">تحديث بيانات عنصر Portfolio.</div>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">بيانات العمل</div>

    <div class="card-body db-card-body">
        <form method="POST" action="{{ route('admin.portfolio-items.update', $portfolioItem->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.portfolio-items.partials.form')

            <div class="mt-3">
                <button class="db-btn-primary">تحديث</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const mediaTypeSelect = document.getElementById('media_type');
        const imageFields     = document.querySelectorAll('.media-image');
        const youtubeFields   = document.querySelectorAll('.media-youtube');

        function toggle(value) {
            imageFields.forEach(el => {
                el.style.display = value === 'image' ? '' : 'none';
            });
            youtubeFields.forEach(el => {
                el.style.display = value === 'youtube' ? '' : 'none';
            });
        }

        if (mediaTypeSelect) {
            toggle(mediaTypeSelect.value);
            mediaTypeSelect.addEventListener('change', function () {
                toggle(this.value);
            });
        }

        // معاينة الصورة عند الاختيار
        const imageInput   = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const previewWrap  = document.getElementById('image-preview-wrapper');
        const fileName     = document.getElementById('image-file-name');

        if (imageInput) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                if (fileName) fileName.textContent = file.name;

                const reader = new FileReader();
                reader.onload = function (e) {
                    if (imagePreview) imagePreview.src = e.target.result;
                    if (previewWrap)  previewWrap.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            });
        }
    })();
</script>
@endsection
