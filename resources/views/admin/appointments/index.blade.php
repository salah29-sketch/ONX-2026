@extends('layouts.admin')

@section('content')
@can('appointment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.appointments.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.appointment.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.appointment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Appointment">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ trans('cruds.appointment.fields.id') }}</th>
                    <th>{{ trans('cruds.appointment.fields.client') }}</th>
                    <th>{{ trans('cruds.appointment.fields.employee') }}</th>
                    <th>{{ trans('cruds.appointment.fields.event_location') }}</th>
                    <th>{{ trans('cruds.appointment.fields.start_time') }}</th>
                    <th>{{ trans('cruds.appointment.fields.price') }}</th>
                    <th>{{ trans('cruds.appointment.fields.deposit') }}</th>
                    <th>{{ trans('cruds.appointment.fields.services') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

    @can('appointment_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.appointments.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}');
                return;
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                    headers: { 'x-csrf-token': _token },
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }
                }).done(function () {
                    location.reload();
                });
            }
        }
    };
    dtButtons.push(deleteButton);
    @endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.appointments.index') }}",
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'client_name', name: 'client.name' },
            { data: 'employee_name', name: 'employee.name' },
            { data: 'location', name: 'location', title: 'location' },
            { data: 'start_time', name: 'start_time' },
            { data: 'price', name: 'price' },
            { data: 'deposit', name: 'deposit' },
            { data: 'services', name: 'services.name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']],
        pageLength: 100,
        createdRow: function (row, data, dataIndex) {
            if (data.status == 0) {
                $(row).addClass('row-glow');
            }
        }
    };

    $('.datatable-Appointment').DataTable(dtOverrideGlobals);

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

 $(document).on('click', '.confirm-booking', function () {
    let appointmentId = $(this).data('id');

    Swal.fire({
        title: '{{ trans('booking.confirm-booking') }}',
        html: `
            <p>{{ trans('booking.confirm-booking-message') }}</p>
            <input type="number" id="deposit" class="swal2-input" placeholder=" {{ trans('booking.deposit-placeholder') }} " min="0">
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ trans('booking.confirm') }}',
        cancelButtonText: '{{ trans('booking.cancel') }}',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        preConfirm: () => {
            const depositValue = document.getElementById('deposit').value;
            return { deposit: depositValue };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const deposit = result.value.deposit;

            $.ajax({
                url: '/admin/appointments/' + appointmentId + '/confirm',
                method: 'POST',
                headers: { 'x-csrf-token': _token },
                data: {
                    deposit: deposit
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: ' {{ trans('booking.confirmed') }} ',
                            text: '{{ trans('booking.confirmed-message') }}',
                            icon: 'success',
                            confirmButtonText: '{{ trans('booking.ok') }}'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('{{ trans('booking.error') }}', '{{ trans('booking.confirm-failed') }} ', 'error');
                    }
                },
                error: function () {
                    Swal.fire('{{ trans('booking.error') }}', '  {{ trans('booking.confirm-error') }}  ', 'error');
                }
            });
        }
    });
});

</script>
@endsection
