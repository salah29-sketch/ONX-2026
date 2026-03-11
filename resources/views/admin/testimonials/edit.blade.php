@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تعديل رأي عميل</h1>
        <div class="db-page-subtitle">تعديل نص الرأي والبيانات.</div>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="db-btn-primary">رجوع</a>
</div>

<div class="card db-card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>اسم العميل / المُعلِن <span class="text-danger">*</span></label>
                <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $testimonial->client_name) }}" required>
                @error('client_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>الدور أو الوصف</label>
                        <input type="text" name="client_role" class="form-control" value="{{ old('client_role', $testimonial->client_role) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>عنوان فرعي</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $testimonial->subtitle) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>نص الرأي <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control" rows="4" required>{{ old('content', $testimonial->content) }}</textarea>
                @error('content')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>التقييم (1–5)</label>
                        <input type="number" name="rating" class="form-control" value="{{ old('rating', $testimonial->rating) }}" min="1" max="5">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>الحرف الأول</label>
                        <input type="text" name="initial" class="form-control" value="{{ old('initial', $testimonial->initial) }}" maxlength="10">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}" min="0">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="d-block">نشط</label>
                <label class="mb-0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                    عرض الرأي في الصفحة الرئيسية
                </label>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection
