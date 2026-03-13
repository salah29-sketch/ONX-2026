@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تفاصيل الباقة</h1>
        <div class="db-page-subtitle">{{ $adPackage->name }}</div>
    </div>
    <div class="db-page-head-actions">
        <a href="{{ route('admin.ad-packages.edit', $adPackage->id) }}" class="db-btn-primary">
            <i class="fas fa-edit"></i>
            تعديل
        </a>
        <a href="{{ route('admin.ad-packages.index') }}" class="db-btn-secondary">
            <i class="fas fa-arrow-right"></i>
            القائمة
        </a>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-bullhorn mr-2"></i>
        تفاصيل الباقة
    </div>

    <div class="card-body db-card-body">
        <h5 class="db-page-title">{{ $adPackage->name }}</h5>
        @if($adPackage->subtitle)
            <p class="text-muted">{{ $adPackage->subtitle }}</p>
        @endif
        @if($adPackage->description)
            <p>{{ $adPackage->description }}</p>
        @endif

        <hr>

        <h6 class="db-label">المميزات</h6>
        @php
            $features = is_array($adPackage->features)
                ? $adPackage->features
                : (json_decode($adPackage->features ?? '[]', true) ?: []);
        @endphp
        <ul class="mb-4">
            @foreach($features as $f)
                <li>{{ $f }}</li>
            @endforeach
        </ul>

        <div class="db-detail-grid">
            <div class="db-detail-item">
                <div class="db-detail-label">النوع</div>
                <div class="db-detail-value">{{ $adPackage->type == 'monthly' ? 'شهري' : 'مخصص' }}</div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">السعر</div>
                <div class="db-detail-value">
                    @if(!is_null($adPackage->price))
                        {{ number_format((float) $adPackage->price, 0) }} DA
                    @else
                        {{ $adPackage->price_note ?: '—' }}
                    @endif
                </div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">السعر القديم</div>
                <div class="db-detail-value">
                    @if(!is_null($adPackage->old_price))
                        {{ number_format((float) $adPackage->old_price, 0) }} DA
                    @else
                        —
                    @endif
                </div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">مميز / نشط</div>
                <div class="db-detail-value">{{ $adPackage->is_featured ? 'نعم' : 'لا' }} / {{ $adPackage->is_active ? 'نعم' : 'لا' }}</div>
            </div>
        </div>

        <div class="db-form-actions mt-4">
            <a href="{{ route('admin.ad-packages.index') }}" class="db-btn-secondary">
                <i class="fas fa-arrow-right"></i>
                القائمة
            </a>
        </div>
    </div>
</div>
@endsection
