@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Package Details
    </div>

    <div class="card-body">
        <h3>{{ $adPackage->name }}</h3>

        <p>{{ $adPackage->description }}</p>

        <hr>

        <h5>Features</h5>

        @php
            $features = is_array($adPackage->features)
                ? $adPackage->features
                : (json_decode($adPackage->features ?? '[]', true) ?: []);
        @endphp

        <ul>
            @foreach($features as $f)
                <li>{{ $f }}</li>
            @endforeach
        </ul>

        <hr>

        <strong>Type:</strong> {{ $adPackage->type }}
        <br>

        <strong>Price:</strong>
        @if(!is_null($adPackage->price))
            {{ number_format((float) $adPackage->price, 0) }} DA
        @else
            {{ $adPackage->price_note ?: '—' }}
        @endif
        <br>

        <strong>Old Price:</strong>
        @if(!is_null($adPackage->old_price))
            {{ number_format((float) $adPackage->old_price, 0) }} DA
        @else
            —
        @endif
        <br>

        <strong>Featured:</strong>
        {{ $adPackage->is_featured ? 'Yes' : 'No' }}
        <br>

        <strong>Active:</strong>
        {{ $adPackage->is_active ? 'Yes' : 'No' }}
    </div>
</div>
@endsection