@extends('layouts.admin')

@section('styles')

@endsection

@section('content')
<div class="db-page-head">
    <div>
        <h3 class="db-page-title">أماكن الحفلات</h3>
        <p class="db-page-subtitle mb-0">إدارة القاعات والأماكن المتاحة للحجز</p>
    </div>

    <a class="btn db-btn-primary" href="{{ route('admin.eventlocations.create') }}">
        <i class="fas fa-plus"></i>
        <span>إضافة مكان</span>
    </a>
</div>

@if(session('success'))
    <div class="mb-6 inline-flex min-w-[320px] items-center rounded-full border border-green-500/30 bg-green-500/10 px-6 py-3 text-sm font-extrabold text-green-700 shadow-sm">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 inline-flex min-w-[320px] items-center rounded-full border border-red-500/30 bg-red-500/10 px-6 py-3 text-sm font-extrabold text-red-700 shadow-sm">
        {{ session('error') }}
    </div>
@endif

<div class="card db-card">
    <div class="card-header db-card-header">
        <i class="fas fa-map-marker-alt me-2"></i>
        قائمة أماكن الحفلات
    </div>

    <div class="card-body db-card-body">
        @if($locations->count())
            <div class="table-responsive">
                <table class="table db-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-pen"></i> الاسم</th>
                            <th><i class="fas fa-map-marker-alt"></i> العنوان</th>
                            <th class="text-center" style="width: 160px;">
                                <i class="fas fa-gear me-1"></i> العمليات
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{ $location->id }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->address }}</td>
                                <td class="text-center">
                                    <div class="db-actions">
                                        <a href="{{ route('admin.eventlocations.edit', $location->id) }}"
                                           class="btn db-icon-btn db-edit-btn"
                                           title="تعديل">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form action="{{ route('admin.eventlocations.destroy', $location->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المكان؟');"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn db-icon-btn db-delete-btn"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="db-empty">
                <i class="fas fa-map-location-dot"></i>
                <p class="mb-0">لا توجد أماكن حفلات مضافة بعد.</p>
            </div>
        @endif
    </div>
</div>
@endsection