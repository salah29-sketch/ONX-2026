@extends('client.layout')

@section('client_content')
<h2 class="mb-6 text-xl font-black text-white">صوري</h2>
<p class="mb-6 text-sm text-white/60">الحد الأقصى 200 صورة. الصور تظهر لكم ولإدارة الموقع.</p>

<div class="mb-8 rounded-2xl border border-white/10 bg-white/5 p-6">
    <h3 class="font-black text-white">رفع صورة جديدة</h3>
    <form method="POST" action="{{ route('client.photos.store') }}" enctype="multipart/form-data" class="mt-4 flex flex-wrap items-end gap-4">
        @csrf
        <div class="flex-1 min-w-[200px]">
            <input type="file" name="photo" accept="image/*" required class="w-full text-white/80 text-sm">
        </div>
        <button type="submit" class="rounded-full bg-orange-500 px-6 py-2 font-black text-black hover:bg-orange-400">رفع</button>
    </form>
</div>

<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
    @forelse($photos as $p)
        <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5">
            <img src="{{ asset($p->path) }}" alt="صورة" class="h-40 w-full object-cover">
        </div>
    @empty
        <p class="col-span-full text-center text-white/60">لا توجد صور بعد.</p>
    @endforelse
</div>
<div class="mt-6">{{ $photos->links() }}</div>
@endsection
