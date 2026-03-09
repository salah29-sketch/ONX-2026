document.addEventListener('DOMContentLoaded', () => {
    const mediaType = document.getElementById('media_type');
    const imageInput = document.getElementById('image');
    const imageFields = document.querySelectorAll('.media-image');
    const youtubeFields = document.querySelectorAll('.media-youtube');
    const fileName = document.getElementById('image-file-name');
    const preview = document.getElementById('image-preview');
    const previewWrapper = document.getElementById('image-preview-wrapper');

    function toggleMediaFields() {
        if (!mediaType) return;

        const value = mediaType.value;

        imageFields.forEach((el) => {
            el.style.display = value === 'image' ? '' : 'none';
        });

        youtubeFields.forEach((el) => {
            el.style.display = value === 'youtube' ? '' : 'none';
        });
    }

    function previewPortfolioImage(event) {
        const file = event.target.files && event.target.files[0];

        if (!file) {
            if (fileName) fileName.textContent = 'لم يتم اختيار ملف بعد';
            if (preview) preview.src = '';
            if (previewWrapper) previewWrapper.classList.add('d-none');
            return;
        }

        if (fileName) {
            fileName.textContent = file.name;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            if (preview) preview.src = e.target.result;
            if (previewWrapper) previewWrapper.classList.remove('d-none');
        };

        reader.readAsDataURL(file);
    }

    if (mediaType) {
        mediaType.addEventListener('change', toggleMediaFields);
        toggleMediaFields();
    }

    if (imageInput) {
        imageInput.addEventListener('change', previewPortfolioImage);
    }
});