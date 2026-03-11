@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">إضافة سؤال شائع</h1>
        <div class="db-page-subtitle">سؤال وجواب يظهر في صفحة FAQ.</div>
    </div>
    <a href="{{ route('admin.faqs.index') }}" class="db-btn-primary">رجوع</a>
</div>

<div class="card db-card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf

            <div class="form-group">
                <label>السؤال <span class="text-danger">*</span></label>
                <input type="text" name="question" class="form-control" value="{{ old('question') }}" required maxlength="500" placeholder="مثال: كيف أعرف أن تاريخ الحفلة متاح؟">
                @error('question')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>الإجابة <span class="text-danger">*</span></label>
                <textarea name="answer" class="form-control" rows="4" required maxlength="2000" placeholder="نص الإجابة...">{{ old('answer') }}</textarea>
                @error('answer')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-block">نشط</label>
                        <label class="mb-0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            عرض السؤال في الموقع
                        </label>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">حفظ السؤال</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection
