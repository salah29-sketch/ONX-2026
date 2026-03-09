@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Marketing Package
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.ad-packages.update', $adPackage->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $adPackage->name) }}" required>
            </div>

            <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $adPackage->subtitle) }}">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $adPackage->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control">
                    <option value="monthly" {{ old('type', $adPackage->type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="custom" {{ old('type', $adPackage->type) === 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $adPackage->price) }}">
            </div>

            <div class="form-group">
                <label>Old Price</label>
                <input type="number" step="0.01" min="0" name="old_price" class="form-control" value="{{ old('old_price', $adPackage->old_price) }}">
            </div>

            <div class="form-group">
                <label>Price Note</label>
                <input type="text" name="price_note" class="form-control" value="{{ old('price_note', $adPackage->price_note) }}">
            </div>

            <div class="form-group">
    <label>Features</label>

    @php
        $features = is_array($adPackage->features)
            ? $adPackage->features
            : (json_decode($adPackage->features ?? '[]', true) ?: preg_split("/\r\n|\n|\r/", (string) ($adPackage->features ?? '')));
        
        $features = array_values(array_filter(array_map('trim', $features)));
    @endphp

    <textarea name="features" class="form-control" rows="5">{{ old('features', implode("\n", $features)) }}</textarea>
</div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $adPackage->sort_order) }}">
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

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection