@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">إضافة باقة فعاليات</h1>
        <div class="db-page-subtitle">Add Event Package</div>
    </div>
    <a href="{{ route('admin.event-packages.index') }}" class="db-btn-secondary">
        <i class="fas fa-arrow-right"></i>
        القائمة
    </a>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-plus mr-2"></i>
        إضافة باقة
    </div>

    <div class="card-body db-card-body">
        <form method="POST" action="{{ route('admin.event-packages.store') }}">
            @csrf

            <div class="form-group">
                <label class="db-label">Name</label>
                <input class="form-control db-input" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="db-label">Subtitle</label>
                <input class="form-control db-input" name="subtitle" value="{{ old('subtitle') }}" placeholder="الأكثر طلبًا">
            </div>

            <div class="form-group">
                <label class="db-label">Description</label>
                <textarea class="form-control db-input" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="db-label">Price (DA)</label>
                <input class="form-control db-input" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label class="db-label">Old Price (DA)</label>
                <input class="form-control db-input" name="old_price" type="number" step="0.01" min="0" value="{{ old('old_price') }}">
            </div>

            <div class="form-group">
                <label class="db-label">Features (one per line)</label>
                <textarea class="form-control db-input" name="features" rows="6">{{ old('features') }}</textarea>
            </div>

            <div class="form-group">
                <label class="db-label">Sort Order</label>
                <input class="form-control db-input" name="sort_order" type="number" value="{{ old('sort_order', 0) }}">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Featured (middle)</label>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" id="is_active" {{ old('is_active', 1) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>

            <div class="db-form-actions db-form-actions-lg">
                <button type="submit" class="db-btn-success">
                    <i class="fas fa-save"></i>
                    حفظ
                </button>
                <a class="db-btn-secondary" href="{{ route('admin.event-packages.index') }}">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
