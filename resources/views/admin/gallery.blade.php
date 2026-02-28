@extends('layouts.admin')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
<style>


.btn-custom-filter {
  color: var(--contrast-color);
  font-size: 14px;
  padding: 8px 30px;
  margin: 0 0 0 15px;
  border-radius: 4px;
  transition: 0.3s;
  border: 2px solid var(--accent-color);
  background: transparent;
  text-decoration: none;
  display: inline-block;
}

.btn-custom-filter:hover,
.btn-custom-filter:focus {
  color: var(--default-color);
  background: var(--accent-color);
}

 .btn-outline-primary{
  color: var(--default-color);
  background: var(--accent-color);
}

.btn-custom-filter.active {
  background: var(--accent-color);
  color: var(--default-color);
}

.btn-custom-filter {
  background: transparent;
  color: #333;
  border: 2px solid #c95518;
  padding: 6px 16px;
  transition: 0.3s ease;
  border-radius: 5px;
  font-weight: 600;
}

.btn-custom-filter:hover {
  background: #c95518;
  color: white;
}

/* الزر المفعّل */
.btn-custom-filter.active {
  background: #c95518;
  color: white;
}

  .gallery-container { padding: 50px 20px; background: #f4f4f4; }
  .gallery-filters { text-align: center; margin-bottom: 30px; }
  .gallery-filters .btn { margin: 0 5px; }
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
  }
  .gallery-item { position: relative; }
  .gallery-item img {
    width: 100%;
    border-radius: 8px;
    display: block;
  }
  .gallery-item .delete-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 0, 0, 0.7);
    border: none;
    color: white;
    border-radius: 50%;
    padding: 5px 8px;
    cursor: pointer;
    font-size: 16px;
  }
  .add-photo {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #999;
    border-radius: 8px;
    height: 200px;
    cursor: pointer;
    background: white;
    transition: all 0.2s ease;
  }
  .add-photo:hover { background: #eee; }
  .add-photo i { font-size: 40px; color: #777; }
.gallery-item {
  position: relative;
  overflow: hidden;
}

.center-home-btn {
  position: absolute;
  top: 10%;
  left: 10%;
  transform: translate(-50%, -50%);
  background: rgba(255, 255, 255, 0.7);
  color: #0a862b;
  border: none;
  border-radius: 50%;
  padding: 5px;
  font-size: 16px;
  cursor: default;
  transition: all 0.3s ease;
  z-index: 10;
}
.gallery-item:hover .center-home-btn {
  opacity: 1;
  pointer-events: auto;
}

.center-home-btn:hover {
  background: #0a862b;
  color: white;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

.center-home-btn.active {
  background: #0c921c;
  color: white;
}

</style>
@endsection

@section('content')

  <!-- ✅ معرض الصور -->
  <section class="gallery-container">
    <div class="container">
      <!-- ✅ الفلاتر -->
        <div class="gallery-filters">
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-custom-filter {{ !$filter ? 'active' : '' }}">الكل</a>
    @foreach ($categories as $key => $label)
      <a href="{{ route('admin.gallery.index', ['category' => $key]) }}"
         class="btn btn-custom-filter {{ $filter == $key ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
  </div>

      <!-- ✅ الشبكة -->
      <div class="gallery-grid" id="gallery-grid">
        <!-- ✅ زر رفع صورة جديدة -->
        <div class="add-photo" onclick="document.getElementById('uploadInput').click();">
          <i class="bi bi-upload"></i>
        </div>

        <!-- ✅ الصور -->
        @foreach ($items as $item)
          <div class="gallery-item">
            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
            @if($item->show_in_homepage)
            <div class="center-home-btn active">
                <i class="bi bi-house-fill"></i>
            </div>
            @endif


        <!-- ✅ زر home في وسط الصورة -->
            <button type="button"
                class="center-home-btn toggle-home-btn {{ $item->show_in_homepage ? 'active' : '' }}"
                data-url="{{ route('admin.gallery.toggleHome', $item->id) }}"
                data-status="{{ $item->show_in_homepage ? 'إزالة من الرئيسية' : 'عرض في الرئيسية' }}"
                title="{{ $item->show_in_homepage ? 'إزالة من الرئيسية' : 'عرض في الرئيسية' }}">
        <i class="bi bi-house-fill"></i>
        </button>

  <!-- ✅ زر الحذف -->
  <form method="POST" action="{{ route('admin.gallery.destroy', $item->id) }}" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="delete-btn" data-id="{{ $item->id }}">
      <i class="bi bi-x"></i>
    </button>
  </form>
</div>

        @endforeach
      </div>

      <!-- ✅ زر تحميل المزيد -->
      @if ($items->hasMorePages())
        <div class="text-center mt-4">
          <button id="load-more" class="btn btn-custom-filter"
                  data-page="{{ $items->currentPage() + 1 }}"
                  data-url="{{ route('admin.gallery.index', ['category' => $filter]) }}">
            تحميل المزيد
          </button>
        </div>
      @endif

      <!-- ✅ فورم رفع الصور -->
     <input type="file" id="uploadInput" accept="image/*" style="display:none;">



      <!-- ✅ Modal لرفع الصورة -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="fullUploadForm" method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">رفع صورة جديدة</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body">
          <input type="file" name="image" id="modalImageInput" class="form-control mb-3" accept="image/*" required hidden>

          <input type="text" name="title" class="form-control mb-3" placeholder="العنوان" required>

          <textarea name="description" class="form-control mb-3" placeholder="الوصف" rows="3" required></textarea>

          <select name="category" class="form-control mb-3" required>
            <option value="">اختر التصنيف</option>
            @foreach ($categories as $key => $label)
              <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">رفع</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        </div>
      </div>
    </form>
  </div>
</div>
    </div>
  </section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
const lightbox = GLightbox({ selector: '.glightbox', loop: true });

// ✅ SweetAlert2 لحذف صورة
document.querySelectorAll('.delete-btn').forEach(button => {
  button.addEventListener('click', function () {
    const form = this.closest('form');
    Swal.fire({
      title: 'هل أنت متأكد؟',
      text: 'لا يمكن التراجع عن هذا الإجراء!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'نعم، احذف',
      cancelButtonText: 'إلغاء',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
});



// ✅ عند اختيار صورة نفتح المودال ونملأ input الملف
document.getElementById('uploadInput').addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const modalImageInput = document.getElementById('modalImageInput');
    modalImageInput.files = this.files;
    const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
    modal.show();
  }
});

// ✅ SweetAlert لتأكيد تغيير الحالة في الرئيسية
document.querySelectorAll('.toggle-home-btn').forEach(button => {
  button.addEventListener('click', function () {
    const url = this.dataset.url;
    const actionText = this.dataset.status;

    Swal.fire({
      title: 'هل أنت متأكد؟',
      text: `هل تريد ${actionText}؟`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'نعم',
      cancelButtonText: 'إلغاء',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33'
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        form.appendChild(token);

        document.body.appendChild(form);
        form.submit();
      }
    });
  });
});


// ✅ تحميل المزيد
document.getElementById('load-more')?.addEventListener('click', function () {
  let button = this;
  let page = button.dataset.page;
  let url = button.dataset.url + '&page=' + page;

  button.disabled = true;
  button.innerText = 'جار التحميل...';

  fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
    .then(res => res.text())
    .then(data => {
      if (data.trim() === '') {
        button.innerText = 'لا مزيد من الصور';
      } else {
        document.getElementById('gallery-grid').insertAdjacentHTML('beforeend', data);
        lightbox.reload();
        button.dataset.page = parseInt(page) + 1;
        button.disabled = false;
        button.innerText = 'تحميل المزيد';
      }
    })
    .catch(err => {
      console.error(err);
      button.innerText = 'فشل في التحميل';
    });
});
</script>
@endsection
