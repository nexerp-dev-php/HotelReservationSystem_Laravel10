<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
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

        return view('frontend.room.search_room', compact('rooms', 'check_date_booking_ids'));
    }

    public function SearchedRoomDetails($id, $check_in, $check_out, $person) {
        $room = Room::findOrFail($id);

        $startDate = date('Y-m-d', strtotime($check_in));
        $endDate = date('Y-m-d', strtotime($check_out));
        $allDate = Carbon::create($endDate)->subDay();
        $hotelStayPeriod = CarbonPeriod::create($startDate, $allDate);

        $dateRangeArray = [];
        foreach($hotelStayPeriod as $period) {
            array_push($dateRangeArray, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dateRangeArray)->distinct()->pluck('booking_id')->toArray();

        return view('frontend.room.searched_room_detailed', compact('id', 'check_in', 'check_out', 'person', 'room', 'check_date_booking_ids'));
    }

    public function CheckRoomAvailability(Request $request) {
        $startDate = date('Y-m-d', strtotime($request->check_in));
        $endDate = date('Y-m-d', strtotime($request->check_out));
        $allDate = Carbon::create($endDate)->subDay();
        $hotelStayPeriod = CarbonPeriod::create($startDate, $allDate);

        $dateRangeArray = [];
        foreach($hotelStayPeriod as $period) {
            array_push($dateRangeArray, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dateRangeArray)->distinct()->pluck('booking_id')->toArray();

        $room = Room::withCount('room_numbers')->find($request->room_id);

        $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('room_id', $room->id)->get()->toArray();

        $total_booked_room = array_sum(array_column($bookings, 'assign_rooms_count'));

        $remaining_room = $room->room_numbers_count - $total_booked_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);

        return response()->json(['available_room'=>$remaining_room, 'total_nights'=>$nights]);
    }
}
