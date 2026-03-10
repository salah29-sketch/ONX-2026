@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">Portfolio Items</h1>
        <div class="db-page-subtitle">إدارة الأعمال التي تظهر في الموقع.</div>
    </div>

    <a href="{{ route('admin.portfolio-items.create') }}" class="db-btn-primary">
        <i class="fas fa-plus"></i>
        إضافة عمل
    </a>
</div>



<div class="card db-card">
    <div class="db-card-header">قائمة الأعمال</div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped db-table text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>الخدمة</th>
                        <th>الصورة / الفيديو</th>
                        <th>مميز</th>
                        <th>نشط</th>
                        <th>الترتيب</th>
                        <th>أماكن الظهور</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        @php
                            $thumb = null;

                            if ($item->media_type === 'youtube' && $item->youtube_video_id) {
                                $thumb = 'https://img.youtube.com/vi/' . $item->youtube_video_id . '/hqdefault.jpg';
                            } elseif ($item->image_path) {
                                $thumb = asset($item->image_path);
                            }
                        @endphp

                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->media_type }}</td>
                            <td>{{ $item->service_type ?: '—' }}</td>
                            <td>
                                @if($thumb)
                                    <img src="{{ $thumb }}" alt="{{ $item->title }}" style="width:80px;height:55px;object-fit:cover;border-radius:8px;">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $item->is_featured ? 'نعم' : 'لا' }}</td>
                            <td>{{ $item->is_active ? 'نعم' : 'لا' }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                @forelse($item->placements as $placement)
                                    <span class="badge badge-info">{{ $placement->placement_key }}</span>
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>
                                <div class="db-actions">
                                    <a href="{{ route('admin.portfolio-items.show', $item->id) }}" class="db-icon-btn db-view-btn" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.portfolio-items.edit', $item->id) }}" class="db-icon-btn db-edit-btn" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.portfolio-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="db-icon-btn db-delete-btn" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="db-empty">
                                    <i class="fas fa-images"></i>
                                    لا توجد أعمال حاليًا.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection