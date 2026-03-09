@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">تفاصيل العمل</h1>
        <div class="db-page-subtitle">عرض كامل لبيانات عنصر Portfolio.</div>
    </div>

    <a href="{{ route('admin.portfolio-items.index') }}" class="db-btn-secondary">
        رجوع
    </a>
</div>

<div class="card db-card">
    <div class="db-card-header">بيانات العمل</div>

    <div class="card-body db-card-body">
        @php
            $thumb = null;

            if ($portfolioItem->media_type === 'youtube' && $portfolioItem->youtube_video_id) {
                $thumb = 'https://img.youtube.com/vi/' . $portfolioItem->youtube_video_id . '/hqdefault.jpg';
            } elseif ($portfolioItem->image_path) {
                $thumb = asset($portfolioItem->image_path);
            }
        @endphp

        <div class="row">
            <div class="col-md-4 mb-4">
                @if($thumb)
                    <img src="{{ $thumb }}" alt="{{ $portfolioItem->title }}" class="img-fluid rounded" style="max-height:260px;object-fit:cover;">
                @else
                    <div class="border rounded p-4 text-center text-muted">
                        لا توجد معاينة
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>العنوان</th>
                        <td>{{ $portfolioItem->title }}</td>
                    </tr>
                    <tr>
                        <th>الخدمة</th>
                        <td>{{ $portfolioItem->service_type ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>التصنيف</th>
                        <td>{{ $portfolioItem->category ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>نوع الوسائط</th>
                        <td>{{ $portfolioItem->media_type }}</td>
                    </tr>
                    <tr>
                        <th>Caption</th>
                        <td>{{ $portfolioItem->caption ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>الوصف</th>
                        <td>{{ $portfolioItem->description ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>العميل</th>
                        <td>{{ $portfolioItem->client_name ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>المكان</th>
                        <td>{{ $portfolioItem->location_name ?: '—' }}</td>
                    </tr>
                    <tr>
                        <th>مميز</th>
                        <td>{{ $portfolioItem->is_featured ? 'نعم' : 'لا' }}</td>
                    </tr>
                    <tr>
                        <th>نشط</th>
                        <td>{{ $portfolioItem->is_active ? 'نعم' : 'لا' }}</td>
                    </tr>
                    <tr>
                        <th>الترتيب</th>
                        <td>{{ $portfolioItem->sort_order }}</td>
                    </tr>
                    <tr>
                        <th>تاريخ النشر</th>
                        <td>{{ $portfolioItem->published_at ? $portfolioItem->published_at->format('Y-m-d H:i') : '—' }}</td>
                    </tr>

                    @if($portfolioItem->media_type === 'image')
                        <tr>
                            <th>مسار الصورة</th>
                            <td>{{ $portfolioItem->image_path ?: '—' }}</td>
                        </tr>
                    @endif

                    @if($portfolioItem->media_type === 'youtube')
                        <tr>
                            <th>رابط YouTube</th>
                            <td>
                                @if($portfolioItem->youtube_url)
                                    <a href="{{ $portfolioItem->youtube_url }}" target="_blank">فتح الفيديو</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Video ID</th>
                            <td>{{ $portfolioItem->youtube_video_id ?: '—' }}</td>
                        </tr>
                    @endif

                    <tr>
                        <th>أماكن الظهور</th>
                        <td>
                            @forelse($portfolioItem->placements as $placement)
                                <span class="badge badge-info">{{ $placement->placement_key }}</span>
                            @empty
                                —
                            @endforelse
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection