@foreach ($items as $item)
<a href="{{ asset($item->image_path) }}"
   class="glightbox"
   data-gallery="gallery1"
   data-title="{{ $item->title }}"
   data-description="{{ $item->description }}">
    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
</a>
@endforeach
