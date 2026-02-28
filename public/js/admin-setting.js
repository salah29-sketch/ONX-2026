function triggerImageUpload(imgElement) {
  const wrapper = imgElement.closest('.editable-image-wrapper');
  const key = imgElement.dataset.key;
  const input = wrapper.querySelector('.image-uploader');

  input.onchange = function () {
    const file = this.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('image', file);
    formData.append('key', key);

    fetch(uploadImage, {
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        imgElement.src = data.url;
        Swal.fire({
            icon: 'success',
            title: 'نجاح',
            text: '✅ تم رفع الصورة بنجاح',
            confirmButtonText: 'موافق'
        });
      } else {
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: '❌ فشل رفع الصورة',
            confirmButtonText: 'فهمت'
        });
      }
    });
  };

  input.click();
}

let currentEditableEl = null;
let pendingKey = '';
let pendingNewValue = '';

function makeEditable(element) {
  const key = element.dataset.key;
  const currentText = element.innerText.trim();
  const input = document.createElement("input");
  input.type = "text";
  input.value = currentText.includes("Modifier") ? '' : currentText;
  input.style.width = "100%";

  input.onblur = function () {
    const newValue = input.value.trim();
    currentEditableEl = element;
    pendingKey = key;
    pendingNewValue = newValue;
    const modal = new bootstrap.Modal(document.getElementById('editConfirmModal'));
    modal.show();
  };

  element.innerHTML = '';
  element.appendChild(input);
  input.focus();
}

document.getElementById("confirmEditBtn").addEventListener("click", function () {
  const modal = bootstrap.Modal.getInstance(document.getElementById('editConfirmModal'));
  modal.hide();

  const currentLang = document.documentElement.lang || 'fr';

  currentEditableEl.innerHTML = pendingNewValue || '<i class="bi bi-pencil-fill text-muted"> Modifier</i>';

fetch(updateUrl, {
  method: "POST",
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  },
  body: JSON.stringify({
    key: pendingKey,
    value: pendingNewValue,
    locale: currentLang
  })
})
.then(res => res.json())
.then(data => {
  if (data.success) {
  Swal.fire({
    icon: 'success',
    title: 'تم الحفظ',
    text: '✅ تم حفظ التعديل بنجاح',
    confirmButtonText: 'موافق'
  });
} else {
  Swal.fire('خطأ', data.message || 'حدث خطأ غير متوقع', 'error');
}

})
.catch(err => {
  Swal.fire('خطأ', 'فشل الاتصال بالخادم', 'error');
});


});


// ✅ تحديث بيانات الخدمات (خارج منطق editable)
document.querySelectorAll('.edit-service-form').forEach(form => {
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const data = new FormData(this);

    fetch(serivesList, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: data
    })
    .then(res => {
      const contentType = res.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
        return res.json();
      } else {
        return res.text().then(text => {
          throw new Error("Expected JSON, got HTML:\n" + text);
        });
      }
    })
    .then(response => {
      if (response.success) {
        Swal.fire({
          icon: 'success',
          title: 'Succès',
          text: '✅ Service mis à jour avec succès !',
          confirmButtonText: 'فهمت'
        }).then((result) => {
          const modalEl = form.closest('.modal');
          const modalInstance = bootstrap.Modal.getInstance(modalEl);
          if (modalInstance) {
            modalInstance.hide();
          }
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: '❌ Erreur lors de la mise à jour',
          confirmButtonText: 'فهمت'
        });
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: '❌ Une erreur inattendue est survenue',
        confirmButtonText: 'فهمت'
      });
    });
  });
});
