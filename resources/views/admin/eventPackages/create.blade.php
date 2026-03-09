@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header">Add Package</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.event-packages.store') }}">
      @csrf

      <div class="form-group">
        <label>Name</label>
        <input class="form-control" name="name" value="{{ old('name') }}" required>
      </div>

      <div class="form-group">
        <label>Subtitle</label>
        <input class="form-control" name="subtitle" value="{{ old('subtitle') }}" placeholder="الأكثر طلبًا">
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>

      <div class="form-group">
        <label>Price (DA)</label>
        <input class="form-control" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}">
      </div>

      <div class="form-group">
        <label>Old Price (DA)</label>
        <input class="form-control" name="old_price" type="number" step="0.01" min="0" value="{{ old('old_price') }}">
      </div>

      <div class="form-group">
        <label>Features (one per line)</label>
        <textarea class="form-control" name="features" rows="6">{{ old('features') }}</textarea>
      </div>

      <div class="form-group">
        <label>Sort Order</label>
        <input class="form-control" name="sort_order" type="number" value="{{ old('sort_order', 0) }}">
      </div>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
        <label class="form-check-label" for="is_featured">Featured (middle)</label>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="is_active" value="1" id="is_active" {{ old('is_active', 1) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
      </div>

      <button class="btn btn-primary">Save</button>
      <a class="btn btn-secondary" href="{{ route('admin.event-packages.index') }}">Cancel</a>
    </form>
  </div>
</div>
@endsection