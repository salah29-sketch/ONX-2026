{{-- قيم افتراضية مشتركة لجدول DataTables يعمل بـ Ajax (لغة عربية، خيارات موحدة) --}}
<script>
(function () {
    window.dtArabicAjaxDefaults = {
        processing: true,
        serverSide: true,
        retrieve: true,
        searching: true,
        lengthChange: false,
        pageLength: 25,
        info: true,
        paging: true,
        ordering: true,
        aaSorting: [[0, 'desc']],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json',
            search: '',
            searchPlaceholder: 'بحث...'
        },
        scrollX: false,
        dom: '<"row mb-3"<"col-sm-12 col-md-6"f>>rt<"row mt-2"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    };
})();
</script>
