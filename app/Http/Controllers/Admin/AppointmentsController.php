<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Appointment;
use App\Models\EventLocation;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreAppointmentRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Requests\MassDestroyAppointmentRequest;
use Illuminate\Support\Facades\Gate;

class AppointmentsController extends Controller
{
    public function __construct(private AppointmentService $appointmentService) {}

    public function index(Request $request)
    {

     if ($request->ajax()) {

        $query = Appointment::with(['client', 'employee', 'services', 'eventLocation'])
            ->select(sprintf('%s.*', (new Appointment)->table));

        $table = Datatables::of($query)
            ->addColumn('placeholder', '&nbsp;')
            ->addColumn('actions', '&nbsp;')

            ->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '';
            })

            ->addColumn('employee_name', function ($row) {
                return $row->employee ? $row->employee->name : '';
            })

            ->addColumn('location', function ($row) {
                return $row->eventLocation
                    ? $row->eventLocation->name
                    : $row->custom_event_location;
            })

            ->editColumn('id', function ($row) {
                return $row->id ?? '';
            })

            ->editColumn('price', function ($row) {
                return $row->price ?? '';
            })

            ->editColumn('deposit', function ($row) {
                return $row->deposit ?? '';
            })

            ->editColumn('status', function ($row) {
                return $row->status ?? '';
            })

            ->editColumn('services', function ($row) {
                $labels = [];

                foreach ($row->services as $service) {
                    $labels[] = sprintf(
                        '<span class="label label-info label-many">%s</span>',
                        e($service->name)
                    );
                }

                return implode(' ', $labels);
            })

            ->editColumn('actions', function ($row) {
                $viewGate      = 'appointment_show';
                $editGate      = 'appointment_edit';
                $deleteGate    = 'appointment_delete';
                $crudRoutePart = 'appointments';

                $actions = view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ))->render();

                if ($row->status == 0) {
                    $confirmBtn = '<button class="btn btn-sm btn-success confirm-booking"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmModal"
                                        data-id="' . $row->id . '">
                                        <i class="fas fa-check-circle"></i>
                                   </button>';
                    $actions .= ' ' . $confirmBtn;
                }

                return $actions;
            })

            ->rawColumns(['actions', 'placeholder', 'services', 'location'])
            ->make(true);

        return $table;
    }

    return view('admin.appointments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Client::select('id', 'name')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::select('id', 'name')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::select('id', 'name')->get()->pluck('name', 'id');

        $event_locations = EventLocation::select('id', 'name')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.appointments.create', compact('clients', 'employees', 'services', 'event_locations'));
    }

    public function store(StoreAppointmentRequest $request)
    {

        $data = $request->all();
        $data['status'] = 1;

        $appointment = Appointment::create($data);
        $appointment->services()->sync($request->input('services', []));

           return redirect()->route('admin.appointments.index');

    }

    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Client::select('id', 'name')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::select('id', 'name')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::select('id', 'name')->get()->pluck('name', 'id');

        $appointment->load('client', 'employee', 'services');

        return view('admin.appointments.edit', compact('clients', 'employees', 'services', 'appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->all();
        $data['status'] = 1; // حجز مؤكد من طرف الأدمن
        $appointment->update($data);
        $appointment->services()->sync($request->input('services', []));

        return redirect()->route('admin.appointments.index');
    }

    public function show(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->load('client', 'employee', 'services', 'eventLocation');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }



    public function confirm($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        $deposit = $request->filled('deposit') ? (float) $request->input('deposit') : null;

        $this->appointmentService->confirm($appointment, $deposit);

        return response()->json(['success' => true]);
    }
}
