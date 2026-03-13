@extends('client.layout')

@section('title', 'ملفاتي - بوابة العملاء')

@push('styles')
<style>
.file-card { display: flex; align-items: center; gap: 16px; padding: 16px; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; text-decoration: none; color: inherit; transition: border-color .2s, box-shadow .2s; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.file-card:hover { border-color: #fcd34d; box-shadow: 0 4px 12px rgba(0,0,0,.06); }
.file-card-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
.file-card-info { flex: 1; min-w: 0; }
.file-card-name { font-size: 15px; font-weight: 800; color: #1f2937; margin-bottom: 4px; }
.file-card-meta { font-size: 12px; color: #6b7280; }
.file-card-dl { font-size: 20px; color: #9ca3af; }
.file-card:hover .file-card-dl { color: #b45309; }
.empty-state-portal { text-align: center; padding: 48px 24px; color: #6b7280; background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
.empty-state-portal .icon { font-size: 48px; margin-bottom: 16px; opacity: .6; }
</style>
@endpush

@section('client_content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-gray-800">📁 ملفاتي</h1>
    <p class="mt-1 text-sm text-gray-500">الفيديو النهائي، PDF، وملفات ZIP المتاحة للتحميل</p>
</div>

@forelse($files as $file)
    <a href="{{ route('client.files.download', $file->id) }}" class="file-card" download>
        <div class="file-card-icon" style="background: {{ $file->typeColor() }}20; color: {{ $file->typeColor() }};">
            <i class="bi {{ $file->typeIcon() }}"></i>
        </div>
        <div class="file-card-info">
            <div class="file-card-name">{{ $file->label }}</div>
            <div class="file-card-meta">
                {{ $file->booking ? 'حجز #' . $file->booking->id : '' }}
                @if($file->size) · {{ $file->humanSize() }} @endif
                · {{ $file->created_at->format('d/m/Y') }}
            </div>
        </div>
        <i class="bi bi-download file-card-dl"></i>
    </a>
@empty
    <div class="empty-state-portal rounded-2xl border border-white/10 bg-white/5">
        <div class="icon">📁</div>
        <p class="font-bold text-gray-700">لا توجد ملفات متاحة حالياً</p>
        <p class="mt-2 text-sm text-gray-500">عند رفع الفيديو النهائي أو أي ملف من الفريق، سيظهر هنا للتحميل.</p>
    </div>
@endforelse
@endsection
