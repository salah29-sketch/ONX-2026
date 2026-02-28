<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\BookingNote;
use App\Models\GalleryItem;
use App\Models\ServiceHome;
use App\Models\EventLocation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
       public function index(){

           $homepageImages = GalleryItem::where('show_in_homepage', true)->latest()->take(6)->get();

           $data = 'index';

            $employees = $employees = Employee::with(['services', 'appointments', 'media'])->get();

            $services = ServiceHome::all();


        return view('main',compact('homepageImages', 'data' , 'employees', 'services'));
    }


public function portfolio(Request $request)
{
    $filter = $request->query('category');

    $query = GalleryItem::when($filter, function ($query, $category) {
        return $query->where('category', $category);
    });

    $items = $query->latest()->paginate(3);

    if ($request->ajax()) {
        return view('partials._gallery_items', compact('items'))->render();
    }

    $categories = [
        'wedding' => 'زفاف',
        'engagement' => 'خطوبة',
        'baby' => 'أطفال',
        'event' => 'مناسبات'
    ];

    $data = ['data' => 'index'];

    return view('portfolio', compact('items', 'categories', 'filter', 'data'));
}


    public function booking(){

        $services = Service::all()->keyBy('id'); // أو ->get() حسب الحاجة
        $note = BookingNote::first();
        $event_locations = EventLocation::all()->pluck('name', 'id')
        ->prepend('مكان آخر', 'other') // ⬅️ يُضيف خيار "مكان آخر"
        ->prepend(trans('global.pleaseSelect'), '');

        return view('booking' , ['data'=>"starter" , 'services'=>$services, 'note' => $note,'event_locations'=> $event_locations]);
    }

       public function checkAvailability(Request $request)
      {

                $request->validate([
                'datetime' => 'required|date',
            ]);

            $targetDate = Carbon::parse($request->datetime)->toDateString();

            $conflict = Appointment::whereDate('start_time', $targetDate)->exists();



            return response()->json([
                'available' => !$conflict
            ]);
     }


   }
