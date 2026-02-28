<?php

namespace App\Http\Controllers\admin;

use App\EventLocation ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;

class EventLocationController extends Controller
{

    use MediaUploadingTrait;

    public function index(Request $request)
     {


        if ($request->ajax()) {
         Log::info('Ajax request started'); // يظهر في logs

        try {
            $query = EventLocation::query()->select(sprintf('%s.*', (new EventLocation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'event_show';
                $editGate      = 'event_edit';
                $deleteGate    = 'event_delete';
                $crudRoutePart = 'event-locations';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });

            $table->rawColumns(['actions','photo', 'placeholder']);


            return $table->make(true);
        } catch (\Exception $e) {
             Log::error('Error in AJAX index: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
     }
        return view('admin.event-location.index');


    }


    public function create(){

       return  view('admin.event-location.create');
    }

    public function store(Request $request)
    {

        $eventLocation = EventLocation::create($request->all());

           if ($request->input('photo', false)) {
                    $eventLocation->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
                }
        return redirect()->back()->with('success', 'تمت إضافة مكان الحفل بنجاح.');
    }

      public function destroy(EventLocation $EventLocation)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $EventLocation->delete();

        return back();
    }
}
