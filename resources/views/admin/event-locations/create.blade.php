@extends('layouts.admin')

@section('styles')

@endsection

@section('content')
<div class="card db-card">
    <div class="card-header db-card-header">
        <i class="fas fa-plus-circle me-2"></i>
        إضافة مكان حفل
    </div>

    <div class="card-body db-card-body">
        <form action="{{ route('admin.eventlocations.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3 {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" class="db-label">
                    <i class="fas fa-signature me-1"></i>
                    اسم المكان
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control db-input"
                    value="{{ old('name') }}"
                    required
                >
                @if($errors->has('name'))
                    <em class="invalid-feedback d-block">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>

            <div class="form-group mb-3 {{ $errors->has('address') ? 'has-error' : '' }}">
                <label for="address" class="db-label">
                    <i class="fas fa-location-dot me-1"></i>
                    العنوان
                </label>
                <input
                    type="text"
                    id="address"
                    name="address"
                    class="form-control db-input"
                    value="{{ old('address') }}"
                    required
                >
                @if($errors->has('address'))
                    <em class="invalid-feedback d-block">
                        {{ $errors->first('address') }}
                    </em>
                @endif
            </div>

            <div class="db-form-actions">
                <button class="btn db-btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i>
                    <span>حفظ</span>
                </button>

                <a href="{{ route('admin.eventlocations.index') }}" class="btn db-btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    <span>رجوع</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection