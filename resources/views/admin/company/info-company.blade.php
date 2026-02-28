@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">{{ __('panel.company_info') }}</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.company.update') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label>{{ __('panel.company_name') }}</label>
                <input type="text" name="company_name" class="form-control" value="{{ $setting->company_name ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.address') }}</label>
                <input type="text" name="address" class="form-control" value="{{ $setting->address ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.phone') }}</label>
                <input type="text" name="phone" class="form-control" value="{{ $setting->phone ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ $setting->email ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.facebook') }}</label>
                <input type="url" name="facebook" class="form-control" value="{{ $setting->facebook ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.instagram') }}</label>
                <input type="url" name="instagram" class="form-control" value="{{ $setting->instagram ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.twitter') }}</label>
                <input type="url" name="twitter" class="form-control" value="{{ $setting->twitter ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.linkedin') }}</label>
                <input type="url" name="linkedin" class="form-control" value="{{ $setting->linkedin ?? '' }}">
            </div>

            <div class="form-group">
                <label>{{ __('panel.map_embed') }}</label>
                <textarea name="map_embed" class="form-control" rows="4">{{ $setting->map_embed ?? '' }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('panel.update') }}</button>
        </form>
    </div>
</div>
@endsection
