<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomBookedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class FrontEndRoomController extends Controller
{
    public function ListAllRoom() {
        $rooms = Room::latest()->get();
        return view('frontend.room.all_rooms', compact('rooms'));
    }

    public function ShowRoom($id) {
        $room = Room::findOrFail($id);

        return view('frontend.room.show_room', compact('room'));
    }

    public function BookingSearch(Request $request) {
        $request->flash(); //save into session

        if($request->check_in == $request->check_out || strtotime($request->check_out) < strtotime($request->check_in)) {
            $notification = array(
                'message' => 'Invalid check-in and check-out dates.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);            
        }

        $startDate = date('Y-m-d', strtotime($request->check_in));
        $endDate = date('Y-m-d', strtotime($request->check_out));
        $allDate = Carbon::create($endDate)->subDay();
        $hotelStayPeriod = CarbonPeriod::create($startDate, $allDate);

        $dateRangeArray = [];
        foreach($hotelStayPeriod as $period) {
            array_push($dateRangeArray, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dateRangeArray)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('room_numbers')->where('status', '1')->get();

        return view('frontend.room.search_room', compact('rooms', 'check_date_booking_ids', 'check_date_booking_ids'));
    }
}
