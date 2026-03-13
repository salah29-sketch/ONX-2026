@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">إضافة باقة إعلانات</h1>
        <div class="db-page-subtitle">Create Marketing Package</div>
    </div>
    <a href="{{ route('admin.ad-packages.index') }}" class="db-btn-secondary">
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
        <form method="POST" action="{{ route('admin.ad-packages.store') }}">
            @csrf

            <div class="form-group">
                <label class="db-label">Name</label>
                <input type="text" name="name" class="form-control db-input" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="db-label">Subtitle</label>
                <input type="text" name="subtitle" class="form-control db-input" value="{{ old('subtitle') }}">
            </div>

            <div class="form-group">
                <label class="db-label">Description</label>
                <textarea name="description" class="form-control db-input">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="db-label">Type</label>
                <select name="type" class="form-control db-input">
                    <option value="monthly" {{ old('type') === 'monthly' ? 'selected' : '' }}>Monthly Package</option>
                    <option value="custom" {{ old('type') === 'custom' ? 'selected' : '' }}>Custom Ad</option>
                </select>
            </div>

            <div class="form-group">
                <label class="db-label">Price</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control db-input" value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label class="db-label">Old Price</label>
                <input type="number" step="0.01" min="0" name="old_price" class="form-control db-input" value="{{ old('old_price') }}">
            </div>

            <div class="form-group">
                <label class="db-label">Price Note</label>
                <input type="text" name="price_note" class="form-control db-input" value="{{ old('price_note') }}">
            </div>

            <div class="form-group">
                <label class="db-label">Features (one per line)</label>
                <textarea name="features" class="form-control db-input" rows="5">{{ old('features') }}</textarea>
            </div>

            <div class="form-group">
                <label class="db-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control db-input" value="{{ old('sort_order', 0) }}">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    Featured
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="db-form-actions db-form-actions-lg">
                <button type="submit" class="db-btn-success">
                    <i class="fas fa-save"></i>
                    حفظ
                </button>
                <a href="{{ route('admin.ad-packages.index') }}" class="db-btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection