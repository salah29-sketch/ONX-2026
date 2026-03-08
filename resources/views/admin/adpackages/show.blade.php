@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Package Details
    </div>

    <div class="card-body">
        <h3>{{ $adpackage->name }}</h3>

        <p>{{ $adpackage->description }}</p>

        <hr>

        <h5>Features</h5>

        @php
            $features = is_array($adpackage->features)
                ? $adpackage->features
                : (json_decode($adpackage->features ?? '[]', true) ?: []);
        @endphp

        <ul>
            @foreach($features as $f)
                <li>{{ $f }}</li>
            @endforeach
        </ul>

        <hr>

        <strong>Type:</strong> {{ $adpackage->type }}
        <br>

        <strong>Price:</strong>
        @if($adpackage->price)
            {{ number_format($adpackage->price) }} DA
        @else
            {{ $adpackage->price_note }}
        @endif
        <br>

        <strong>Featured:</strong>
        {{ $adpackage->is_featured ? 'Yes' : 'No' }}
        <br>

        <strong>Active:</strong>
        {{ $adpackage->is_active ? 'Yes' : 'No' }}
    </div>
</div>
@endsection