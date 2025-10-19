<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomBookedDate;
use App\Models\BookingRoomList;
use App\Models\RoomNumber;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Stripe;

class RoomListController extends Controller
{
    public function AllRoomList() {
        $room_number_list = RoomNumber::with(['room_type', 'last_booking.booking:id,check_in,check_out,status,invoice_no,name,phone'])
            ->orderBy('roomtype_id', 'asc')->leftJoin('room_types', 'room_types.id', 'room_numbers.roomtype_id')
            ->leftJoin('booking_room_lists', 'booking_room_lists.room_number_id', 'room_numbers.id')
            ->leftJoin('bookings', 'bookings.id', 'booking_room_lists.booking_id')
            ->select(
                'room_numbers.*',
                'room_numbers.id as id',
                'room_types.name',
                'bookings.id as booking_id',
                'bookings.check_in',
                'bookings.check_out',
                'bookings.name as customer_name',
                'bookings.phone as customer_phone',
                'bookings.status as booking_status',
                'bookings.invoice_no as booking_no'
            )
            ->orderBy('room_types.name', 'asc')
            ->orderBy('bookings.id', 'desc')
            ->get();

        return view('backend.roomlist.all_room_list', compact('room_number_list'));
    }

    public function AddRoomBooking() {
        $roomtype = RoomType::all();

        return view('backend.roomlist.add_room_booking', compact('roomtype'));
    }

    public function StoreRoomBooking(Request $request) {
        if($request->check_in == $request->check_out) {
            $request->flash();
            
            $notification = array(
                'message' => 'Invalid date range.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);       
        }

        if($request->available_room < $request->number_of_rooms) {
            $request->flash();

            $notification = array(
                'message' => 'Number of rooms requested could not be fulfilled',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);              
        }

        $room = Room::find($request->room_id);
        if($room->room_capacity < $request->person) {
            $request->flash();

            $notification = array(
                'message' => 'Selected room type could not fit the number of persons.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);    
        }

        $startDate = Carbon::parse($request->check_in);
        $endDate = Carbon::parse($request->check_out);
        $hotelStayPeriod = $startDate->diffInDays($endDate);

        $subTotal = $room->price * $hotelStayPeriod * $request->number_of_rooms;
        $discountedAmount = ($room->discount/100) * $subTotal;
        $totalPrice = $subTotal - $discountedAmount;
        $code = rand(000000000, 999999999);

        $data = new Booking();
        $data->room_id = $room->id;
        $data->user_id = Auth::user()->id;
        $data->check_in = date('Y-m-d', strtotime($request->check_in));
        $data->check_out = date('Y-m-d', strtotime($request->check_out));
        $data->person = $request->person;
        $data->number_of_rooms = $request->number_of_rooms;
        $data->total_stay = $hotelStayPeriod;
        $data->actual_price = $room->price;
        $data->subtotal = $subTotal;
        $data->discount = $discountedAmount;
        $data->total_price = $totalPrice;
        $data->payment_method = '';
        $data->payment_status = 0;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->country = $request->country;
        $data->state = $request->state;
        $data->zip_code = $request->zip_code;
        $data->address = $request->address;
        $data->invoice_no = $code;
        $data->status = 0;
        $data->created_at = Carbon::now();

        $data->save();

        $sDate = date('Y-m-d', strtotime($request->check_in));
        $eDate = date('Y-m-d', strtotime($request->check_out));
        $allDate = Carbon::create($eDate)->subDay();
        $dateRange = CarbonPeriod::create($sDate, $allDate);

        foreach($dateRange as $date) {
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $data->id;
            $booked_dates->room_id = $room->id;
            $booked_dates->book_date = date('Y-m-d', strtotime($date));
            $booked_dates->save();
        }

        $notification = array(
            'message' => 'Booking added successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('all.room.list')->with($notification);  
    }
}
