@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">باقات الفعاليات (Event Packages)</h1>
        <div class="db-page-subtitle">إدارة باقات الحفلات والفعاليات.</div>
    </div>
    <a class="db-btn-primary" href="{{ route('admin.event-packages.create') }}">
        <i class="fas fa-plus"></i>
        إضافة باقة
    </a>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-calendar-alt mr-2"></i>
        قائمة الباقات
    </div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped db-table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Subtitle</th>
                        <th>Price</th>
                        <th>Old Price</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th width="160"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($eventPackages as $package)
                        <tr>
                            <td>{{ $package->id }}</td>

                            <td>
                                <strong>{{ $package->name }}</strong>
                            </td>

                            <td>
                                {{ $package->subtitle ?? '—' }}
                            </td>

                            <td>
                                @if($package->price !== null)
                                    {{ number_format((float) $package->price, 0) }} DA
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                @if($package->old_price !== null)
                                    {{ number_format((float) $package->old_price, 0) }} DA
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                @if($package->is_featured)
                                    ⭐
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                {{ $package->is_active ? 'نعم' : 'لا' }}
                            </td>

                            <td>{{ $package->sort_order ?? 0 }}</td>

                            <td>
                                <div class="db-actions">
                                    <a class="db-icon-btn db-view-btn" href="{{ route('admin.event-packages.show', $package->id) }}" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="db-icon-btn db-edit-btn" href="{{ route('admin.event-packages.edit', $package->id) }}" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.event-packages.destroy', $package->id) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الباقة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="db-icon-btn db-delete-btn" title="حذف">
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
        <div class="mt-3">{{ $eventPackages->links() }}</div>
    </div>
</div>
@endsection
