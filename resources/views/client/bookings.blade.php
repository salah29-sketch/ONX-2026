@extends('client.layout')

@section('client_content')
<h2 class="mb-6 text-xl font-black text-white">حجوزاتي</h2>
<div class="space-y-4">
    @forelse($bookings as $b)
        <a href="{{ route('client.bookings.show', $b) }}" class="block rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-orange-500/30">
            <div class="flex justify-between flex-wrap gap-2">
                <span class="font-black text-white">#{{ $b->id }}</span>
                <span class="text-sm text-white/60">{{ $b->created_at->format('Y-m-d') }}</span>
            </div>
            <p class="mt-2 text-sm text-white/70">الحالة: <strong>{{ $b->status }}</strong></p>
        </a>
    @empty
        <p class="rounded-2xl border border-white/10 bg-white/5 p-6 text-center text-white/60">لا توجد حجوزات.</p>
    @endforelse
</div>
<div class="mt-6">{{ $bookings->links() }}</div>
@endsection
