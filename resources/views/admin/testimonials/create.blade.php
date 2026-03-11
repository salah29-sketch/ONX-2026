@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">إضافة رأي عميل</h1>
        <div class="db-page-subtitle">شهادة تظهر في قسم «آراء العملاء» بالصفحة الرئيسية.</div>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="db-btn-primary">رجوع</a>
</div>

<div class="card db-card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.testimonials.store') }}">
            @csrf

            <div class="form-group">
                <label>اسم العميل / المُعلِن <span class="text-danger">*</span></label>
                <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" required placeholder="مثال: عميل — إعلان تجاري">
                @error('client_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>الدور أو الوصف (اختياري)</label>
                        <input type="text" name="client_role" class="form-control" value="{{ old('client_role') }}" placeholder="مثال: عميل — إعلان تجاري">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>عنوان فرعي (اختياري)</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="مثال: علامة تجارية">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>نص الرأي <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control" rows="4" required placeholder="اقتباس أو شهادة العميل...">{{ old('content') }}</textarea>
                @error('content')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>التقييم (1–5)</label>
                        <input type="number" name="rating" class="form-control" value="{{ old('rating', 5) }}" min="1" max="5">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>الحرف الأول (للعرض)</label>
                        <input type="text" name="initial" class="form-control" value="{{ old('initial') }}" maxlength="10" placeholder="اتركه فارغاً لاستخدام أول حرف من الاسم">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="d-block">نشط</label>
                <label class="mb-0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    عرض الرأي في الصفحة الرئيسية
                </label>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">حفظ الرأي</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection
