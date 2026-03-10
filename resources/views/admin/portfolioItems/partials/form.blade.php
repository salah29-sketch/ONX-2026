@php
    $currentMediaType = old('media_type', $portfolioItem->media_type ?? 'image');
@endphp

<div class="portfolio-form-body">

    {{-- البيانات الأساسية --}}
    <section class="pf-section">
        <div class="pf-section-head">
            <div>
                <div class="pf-section-kicker">البيانات الأساسية</div>
                <h2 class="pf-section-title">معلومات العمل</h2>
                <p class="pf-section-text">أدخل عنوان العمل ونوعه وتصنيفه وبعض المعلومات التعريفية.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <label class="pf-label">العنوان</label>
                <input
                    type="text"
                    name="title"
                    class="form-control pf-input"
                    value="{{ old('title', $portfolioItem->title ?? '') }}"
                    required
                >
            </div>

            <div class="col-md-3">
                <label class="pf-label">نوع الخدمة</label>
                <select name="service_type" class="form-control pf-input">
                    <option value="">—</option>
                    <option value="event" {{ old('service_type', $portfolioItem->service_type ?? '') === 'event' ? 'selected' : '' }}>
                        حفلات
                    </option>
                    <option value="ads" {{ old('service_type', $portfolioItem->service_type ?? '') === 'ads' ? 'selected' : '' }}>
                        إعلانات
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="pf-label">التصنيف</label>
                <input
                    type="text"
                    name="category"
                    class="form-control pf-input"
                    value="{{ old('category', $portfolioItem->category ?? '') }}"
                    placeholder="wedding / restaurant / brand"
                >
            </div>

            <div class="col-md-6">
                <label class="pf-label">Caption</label>
                <input
                    type="text"
                    name="caption"
                    class="form-control pf-input"
                    value="{{ old('caption', $portfolioItem->caption ?? '') }}"
                >
            </div>

            <div class="col-md-3">
                <label class="pf-label">اسم العميل</label>
                <input
                    type="text"
                    name="client_name"
                    class="form-control pf-input"
                    value="{{ old('client_name', $portfolioItem->client_name ?? '') }}"
                >
            </div>

            <div class="col-md-3">
                <label class="pf-label">المكان</label>
                <input
                    type="text"
                    name="location_name"
                    class="form-control pf-input"
                    value="{{ old('location_name', $portfolioItem->location_name ?? '') }}"
                >
            </div>

            <div class="col-12">
                <label class="pf-label">الوصف</label>
                <textarea
                    name="description"
                    rows="5"
                    class="form-control pf-input pf-textarea"
                >{{ old('description', $portfolioItem->description ?? '') }}</textarea>
            </div>
        </div>
    </section>

    {{-- الوسائط --}}
    <section class="pf-section">
        <div class="pf-section-head">
            <div>
                <div class="pf-section-kicker">الوسائط</div>
                <h2 class="pf-section-title">الصورة أو الفيديو</h2>
                <p class="pf-section-text">اختر نوع الوسائط، وسيظهر فقط الحقل المناسب للاختيار الحالي.</p>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-md-4">
                <label class="pf-label">نوع الوسائط</label>
                <select name="media_type" id="media_type" class="form-control pf-input">
                    <option value="image" {{ $currentMediaType === 'image' ? 'selected' : '' }}>صورة</option>
                    <option value="youtube" {{ $currentMediaType === 'youtube' ? 'selected' : '' }}>YouTube</option>
                </select>
            </div>

            {{-- صورة --}}
            <div class="col-md-8 media-field media-image">
                <label class="pf-label d-block">رفع الصورة</label>

                <div class="pf-upload-card">
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="d-none"
                        accept="image/*"
                    >

                    <label for="image" class="pf-upload-box">
                        <div class="pf-upload-icon">🖼️</div>
                        <div class="pf-upload-title">اختر صورة للعمل</div>
                        <div class="pf-upload-text">
                            PNG / JPG / JPEG — يفضّل أن تكون الصورة واضحة ومناسبة للعرض
                        </div>
                        <div class="pf-upload-btn">اختيار صورة</div>
                        <div id="image-file-name" class="pf-upload-file-name">لم يتم اختيار ملف بعد</div>
                    </label>

                    <div
                        id="image-preview-wrapper"
                        class="pf-image-preview-wrapper {{ !empty($portfolioItem->image_path ?? null) ? '' : 'd-none' }}"
                    >
                        <div class="pf-preview-head">معاينة الصورة</div>

                        <img
                            id="image-preview"
                            src="{{ !empty($portfolioItem->image_path ?? null) ? asset($portfolioItem->image_path) : '' }}"
                            alt="preview"
                            class="pf-image-preview"
                        >
                    </div>
                </div>

                @error('image')
                    <div class="pf-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- YouTube --}}
            <div class="col-md-8 media-field media-youtube">
                <div class="pf-youtube-card">
                    <label class="pf-label">رابط YouTube</label>
                    <input
                        type="text"
                        name="youtube_url"
                        class="form-control pf-input"
                        value="{{ old('youtube_url', $portfolioItem->youtube_url ?? '') }}"
                        placeholder="https://www.youtube.com/watch?v=..."
                    >
                    <div class="pf-help">يمكنك وضع رابط عادي أو Shorts أو youtu.be</div>

                    @error('youtube_url')
                        <div class="pf-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    {{-- النشر والظهور --}}
    <section class="pf-section">
        <div class="pf-section-head">
            <div>
                <div class="pf-section-kicker">الظهور</div>
                <h2 class="pf-section-title">الترتيب والنشر</h2>
                <p class="pf-section-text">حدّد ترتيب العنصر وحالة نشاطه.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <label class="pf-label">الترتيب</label>
                <input
                    type="number"
                    min="0"
                    name="sort_order"
                    class="form-control pf-input"
                    value="{{ old('sort_order', $portfolioItem->sort_order ?? 0) }}"
                >
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <label class="pf-check-card w-100">
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        {{ old('is_featured', $portfolioItem->is_featured ?? false) ? 'checked' : '' }}
                    >
                    <span>
                        <strong>مميز</strong>
                        <small>إظهار العمل كعنصر بارز في الـ Hero</small>
                    </span>
                </label>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <label class="pf-check-card w-100">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $portfolioItem->is_active ?? true) ? 'checked' : '' }}
                    >
                    <span>
                        <strong>نشط</strong>
                        <small>السماح بعرض العمل داخل الموقع</small>
                    </span>
                </label>
            </div>
        </div>
    </section>

</div>