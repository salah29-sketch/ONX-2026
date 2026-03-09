@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Create Marketing Package
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.ad-packages.store') }}">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control">
                    <option value="monthly" {{ old('type') === 'monthly' ? 'selected' : '' }}>Monthly Package</option>
                    <option value="custom" {{ old('type') === 'custom' ? 'selected' : '' }}>Custom Ad</option>
                </select>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label>Old Price</label>
                <input type="number" step="0.01" min="0" name="old_price" class="form-control" value="{{ old('old_price') }}">
            </div>

            <div class="form-group">
                <label>Price Note</label>
                <input type="text" name="price_note" class="form-control" value="{{ old('price_note') }}">
            </div>

            <div class="form-group">
                <label>Features (one per line)</label>
                <textarea name="features" class="form-control" rows="5">{{ old('features') }}</textarea>
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
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

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection