@php use Illuminate\Support\Str; @endphp

@foreach ($items as $item)
<div class="portfolio-item position-relative">

    <a href="{{ \Storage::url($item->image_path) }}"
       class="glightbox d-block"
       data-gallery="gallery1"
       data-title="{{ $item->title }}"
       data-description="{{ $item->description }}">

        <img src="{{ asset($item->image_path) }}"
     alt="{{ $item->title }}"
     class="portfolio-img">

        <!-- Overlay -->
        <div class="portfolio-overlay">
            <div class="overlay-content text-center text-white">
                <h5 class="mb-1">{{ $item->title }}</h5>
                <p class="small mb-0">{{ Str::limit($item->description, 60) }}</p>
            </div>
        </div>

    </a>

</div>
@endforeach

@if($items->isEmpty())
<div class="col-12 text-center py-5">
    <p class="text-muted">لا توجد عناصر حالياً</p>
</div>
@endif