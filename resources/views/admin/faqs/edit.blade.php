@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تعديل سؤال شائع</h1>
        <div class="db-page-subtitle">تعديل السؤال والإجابة.</div>
    </div>
    <a href="{{ route('admin.faqs.index') }}" class="db-btn-primary">رجوع</a>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-edit mr-2"></i>
        تعديل السؤال
    </div>
    <div class="card-body db-card-body">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>السؤال <span class="text-danger">*</span></label>
                <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question) }}" required maxlength="500">
                @error('question')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>الإجابة <span class="text-danger">*</span></label>
                <textarea name="answer" class="form-control" rows="4" required maxlength="2000">{{ old('answer', $faq->answer) }}</textarea>
                @error('answer')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order) }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-block">نشط</label>
                        <label class="mb-0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                            عرض السؤال في الموقع
                        </label>
                    </div>
                </div>
            </div>

            <div class="db-form-actions db-form-actions-lg">
                <button type="submit" class="db-btn-success">
                    <i class="fas fa-save"></i>
                    حفظ التعديلات
                </button>
                <a href="{{ route('admin.faqs.index') }}" class="db-btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
