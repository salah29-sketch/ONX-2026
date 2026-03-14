@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تعديل باقة إعلانات</h1>
        <div class="db-page-subtitle">{{ $adPackage->name }}</div>
    </div>
    <div class="db-page-head-actions">
        <a href="{{ route('admin.ad-packages.show', $adPackage->id) }}" class="db-btn-secondary">
            <i class="fas fa-eye"></i>
            عرض
        </a>
        <a href="{{ route('admin.ad-packages.index') }}" class="db-btn-secondary">
            <i class="fas fa-arrow-right"></i>
            القائمة
        </a>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-edit mr-2"></i>
        تعديل الباقة
    </div>

    <div class="card-body db-card-body">
        <form method="POST" action="{{ route('admin.ad-packages.update', $adPackage->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="db-label">Name</label>
                <input type="text" name="name" class="form-control db-input" value="{{ old('name', $adPackage->name) }}" required>
            </div>

            <div class="form-group">
                <label class="db-label">Subtitle</label>
                <input type="text" name="subtitle" class="form-control db-input" value="{{ old('subtitle', $adPackage->subtitle) }}">
            </div>

            <div class="form-group">
                <label class="db-label">Description</label>
                <textarea name="description" class="form-control db-input">{{ old('description', $adPackage->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="db-label">Type</label>
                <select name="type" class="form-control db-input">
                    <option value="monthly" {{ old('type', $adPackage->type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="custom" {{ old('type', $adPackage->type) === 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>

            <div class="form-group">
                <label class="db-label">Price</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control db-input" value="{{ old('price', $adPackage->price) }}">
            </div>

            <div class="form-group">
                <label class="db-label">Old Price</label>
                <input type="number" step="0.01" min="0" name="old_price" class="form-control db-input" value="{{ old('old_price', $adPackage->old_price) }}">
            </div>

            <div class="form-group">
                <label class="db-label">Price Note</label>
                <input type="text" name="price_note" class="form-control db-input" value="{{ old('price_note', $adPackage->price_note) }}">
            </div>

            <div class="form-group">
                <label class="db-label">Features</label>
    @php
        $features = is_array($adPackage->features)
            ? $adPackage->features
            : (json_decode($adPackage->features ?? '[]', true) ?: preg_split("/\r\n|\n|\r/", (string) ($adPackage->features ?? '')));
        
        $features = array_values(array_filter(array_map('trim', $features)));
    @endphp

                <textarea name="features" class="form-control db-input" rows="5">{{ old('features', implode("\n", $features)) }}</textarea>
            </div>

            <div class="form-group">
                <label class="db-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control db-input" value="{{ old('sort_order', $adPackage->sort_order) }}">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $adPackage->is_featured) ? 'checked' : '' }}>
                    Featured
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $adPackage->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="db-form-actions db-form-actions-lg">
                <button type="submit" class="db-btn-success">
                    <i class="fas fa-save"></i>
                    تحديث
                </button>
                <a href="{{ route('admin.ad-packages.index') }}" class="db-btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection