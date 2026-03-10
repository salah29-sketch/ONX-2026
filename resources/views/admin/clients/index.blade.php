@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">العملاء</h1>
        <div class="db-page-subtitle">إدارة العملاء ومراجعة بياناتهم وحجوزاتهم المرتبطة.</div>
    </div>

    @can('client_create')
        <a class="db-btn-primary" href="{{ route('admin.clients.create') }}">
            <i class="fas fa-plus"></i>
            إضافة عميل
        </a>
    @endcan
</div>



<div class="card db-card">
    <div class="db-card-header">قائمة العملاء</div>

    <div class="card-body db-card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Client db-table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>البريد الإلكتروني</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtOverrideGlobals = {
            processing: true,
            serverSide: true,
            retrieve: true,
            searching: false,
            lengthChange: false,
            info: false,
            paging: false,
            ordering: true,
            aaSorting: [],
            ajax: "{{ route('admin.clients.index') }}",
            columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'phone', name: 'phone' },
    { data: 'email', name: 'email' },
    { data: 'actions', name: '{{ trans('global.actions') }}', sortable: false, searchable: false }
],
order: [[0, 'desc']],
            scrollX: false,
            dom: 'rt'
        };

        $('.datatable-Client').DataTable(dtOverrideGlobals);
    });
</script>
@endsection