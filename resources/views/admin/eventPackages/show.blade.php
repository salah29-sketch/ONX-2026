@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header">Package Details</div>
  <div class="card-body">
    <div><strong>Name:</strong> {{ $eventPackage->name }}</div>
    <div><strong>Subtitle:</strong> {{ $eventPackage->subtitle }}</div>
    <div><strong>Price:</strong> {{ $eventPackage->price }} DA</div>
    <div><strong>Featured:</strong> {{ $eventPackage->is_featured ? 'Yes' : 'No' }}</div>
    <div><strong>Active:</strong> {{ $eventPackage->is_active ? 'Yes' : 'No' }}</div>
    <div><strong>Sort:</strong> {{ $eventPackage->sort_order }}</div>
    <hr>
    <div><strong>Description:</strong> {{ $eventPackage->description }}</div>
    <hr>
    <div><strong>Features:</strong></div>
    <ul>
      @foreach(($eventPackage->features ?? []) as $f)
        <li>{{ $f }}</li>
      @endforeach
    </ul>

    <a class="btn btn-secondary" href="{{ route('admin.event-packages.index') }}">Back</a>
  </div>
</div>
@endsection