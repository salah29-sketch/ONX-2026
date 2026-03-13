@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تفاصيل الباقة</h1>
        <div class="db-page-subtitle">{{ $eventPackage->name }}</div>
    </div>
    <div class="db-page-head-actions">
        <a href="{{ route('admin.event-packages.edit', $eventPackage->id) }}" class="db-btn-primary">
            <i class="fas fa-edit"></i>
            تعديل
        </a>
        <a href="{{ route('admin.event-packages.index') }}" class="db-btn-secondary">
            <i class="fas fa-arrow-right"></i>
            القائمة
        </a>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-calendar-alt mr-2"></i>
        تفاصيل الباقة
    </div>

    <div class="card-body db-card-body">
        <div class="db-detail-grid mb-4">
            <div class="db-detail-item">
                <div class="db-detail-label">الاسم</div>
                <div class="db-detail-value">{{ $eventPackage->name }}</div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">العنوان الفرعي</div>
                <div class="db-detail-value">{{ $eventPackage->subtitle ?? '—' }}</div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">السعر</div>
                <div class="db-detail-value">{{ $eventPackage->price !== null ? number_format((float) $eventPackage->price, 0) . ' DA' : '—' }}</div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">السعر القديم</div>
                <div class="db-detail-value">{{ $eventPackage->old_price !== null ? number_format((float) $eventPackage->old_price, 0) . ' DA' : '—' }}</div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">مميز / نشط</div>
                <div class="db-detail-value">{{ $eventPackage->is_featured ? 'نعم' : 'لا' }} / {{ $eventPackage->is_active ? 'نعم' : 'لا' }}</div>
            </div>
            <div class="db-detail-item">
                <div class="db-detail-label">الترتيب</div>
                <div class="db-detail-value">{{ $eventPackage->sort_order }}</div>
            </div>
        </div>
        @if($eventPackage->description)
            <p><strong class="db-detail-label">الوصف:</strong><br>{{ $eventPackage->description }}</p>
        @endif
        @if(count($eventPackage->features ?? []) > 0)
            <h6 class="db-label mt-3">المميزات</h6>
            <ul>
                @foreach($eventPackage->features as $f)
                    <li>{{ $f }}</li>
                @endforeach
            </ul>
        @endif
        <div class="db-form-actions mt-4">
            <a href="{{ route('admin.event-packages.index') }}" class="db-btn-secondary">
                <i class="fas fa-arrow-right"></i>
                القائمة
            </a>
        </div>
    </div>
</div>
@endsection
