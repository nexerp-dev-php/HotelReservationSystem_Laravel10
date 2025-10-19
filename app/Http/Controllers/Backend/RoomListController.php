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
}
