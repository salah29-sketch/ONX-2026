@foreach ($items as $item)
  <div class="gallery-item">
    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
    <form method="POST" action="{{ route('admin.gallery.destroy', $item->id) }}" class="delete-form">
      @csrf
      @method('DELETE')
      <button type="button" class="delete-btn" data-id="{{ $item->id }}"><i class="bi bi-x"></i></button>
    </form>
  </div>
@endforeach
