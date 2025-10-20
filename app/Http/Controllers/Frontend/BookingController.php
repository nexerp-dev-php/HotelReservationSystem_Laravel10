<?php

namespace App\Http\Controllers\Frontend;

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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookConfirm;

class BookingController extends Controller
{
    public function StoreUserBooking(Request $request, $id) {
        $validateData = $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'person' => 'required',
            'number_of_rooms' => 'required',
        ]);

        if($request->available_room < $request->number_of_rooms) {
            $notification = array(
                'message' => 'Requested room exceeded number of available rooms.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);     
        }

        Session::forget('book_date'); //remove session data

        $data = array();
        $data['number_of_rooms'] = $request->number_of_rooms;
        $data['available_room'] = $request->available_room;
        $data['person'] = $request->person;
        $data['check_in'] = date('Y-m-d', strtotime($request->check_in));
        $data['check_out'] = date('Y-m-d', strtotime($request->check_out));
        $data['room_id'] = $request->room_id;

        Session::put('book_date', $data);

        return redirect()->route('checkout');  
    }

    public function Checkout() {
        if(Session::has('book_date')) {
            $book_data = Session::get('book_date');
            $room = Room::find($book_data['room_id']);

            $startDate = Carbon::parse($book_data['check_in']);
            $endDate = Carbon::parse($book_data['check_out']);
            $hotelStayPeriod = $startDate->diffInDays($endDate);

            return view('frontend.checkout.checkout', compact('book_data', 'room', 'hotelStayPeriod'));
        } else {
            $notification = array(
                'message' => 'Please login to the system.',
                'alert-type' => 'error'
            );

            return redirect('/')->with($notification); 
        }
    }

    public function StoreCheckout(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method_opt' => 'required'
        ]);

        $book_data = Session::get('book_date');

        $startDate = Carbon::parse($book_data['check_in']);
        $endDate = Carbon::parse($book_data['check_out']);
        $hotelStayPeriod = $startDate->diffInDays($endDate);
        
        $room = Room::find($book_data['room_id']);
        $subTotal = $room->price * $hotelStayPeriod * $book_data['number_of_rooms'];
        $discountedAmount = ($room->discount/100) * $subTotal;
        $totalPrice = $subTotal - $discountedAmount;
        $code = rand(000000000, 999999999);

        if($request->payment_method_opt == 'Stripe') {
            Stripe\Stripe::setApiKey('');
    $charge = Stripe\Charge::create([
        'amount' => $totalPrice * 100,
        'currency' => 'usd',
        'source' => $request->stripeToken,
        'description' => 'Hotel booking payment',
    ]);

            if ($charge->status === 'succeeded' && $charge->paid) {
                $payment_status = 1;
                $transaction_id = $charge->id;
            } else {
                $notification = array(
                    'message' => 'Unsuccesful payment.',
                    'alert-type' => 'error'
                );

                return redirect('/')->with($notification); 
            }

            /*Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $s_pay = Stripe\Charge::create([
                "amount" => $totalPrice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment for Room Booking. Booking No# ".$code,
            ]);

            if($s_pay['status'] == 'succeeded') {
                $payment_status = 1;
                $transaction_id = $s_pay->id;
            } else {
                $notification = array(
                    'message' => 'Unsuccesful payment.',
                    'alert-type' => 'error'
                );

                return redirect('/')->with($notification); 
            }*/
        } else {
            $payment_status = 0;
            $transaction_id = '';            
        }

        $data = new Booking();
        $data->room_id = $room->id;
        $data->user_id = Auth::user()->id;
        $data->check_in = date('Y-m-d', strtotime($book_data['check_in']));
        $data->check_out = date('Y-m-d', strtotime($book_data['check_out']));
        $data->person = $book_data['person'];
        $data->number_of_rooms = $book_data['number_of_rooms'];
        $data->total_stay = $hotelStayPeriod;
        $data->actual_price = $room->price;
        $data->subtotal = $subTotal;
        $data->discount = $discountedAmount;
        $data->total_price = $totalPrice;
        $data->payment_method = $request->payment_method_opt;
        $data->transaction_id = $transaction_id;
        $data->payment_status = $payment_status;
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

        $sDate = date('Y-m-d', strtotime($book_data['check_in']));
        $eDate = date('Y-m-d', strtotime($book_data['check_out']));
        $allDate = Carbon::create($eDate)->subDay();
        $dateRange = CarbonPeriod::create($sDate, $allDate);

        foreach($dateRange as $date) {
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $data->id;
            $booked_dates->room_id = $room->id;
            $booked_dates->book_date = date('Y-m-d', strtotime($date));
            $booked_dates->save();
        }

        Session::forget('book_date');

        $notification = array(
            'message' => 'Booking added successfully.',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);      
    }

    public function AllBooking() {
        $bookings = Booking::orderBy('id', 'desc')->get();

        return view('backend.booking.booking_list', compact('bookings'));
    }

    public function EditBooking($id) {
        $booking = Booking::with('room')->findOrFail($id);

        return view('backend.booking.edit_booking', compact('booking'));
    }

    public function StoreFinalizedBooking(Request $request, $id) {
        $booking = Booking::findOrFail($id);
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;

        $booking->save();

        $sendmail = $booking;
        $mailData = [
            'check_in' => $sendmail->check_in,
            'check_out' => $sendmail->check_out,
            'name' => $sendmail->name,
            'email' => $sendmail->email,
            'phone' => $sendmail->phone
        ];

        Mail::to($sendmail->email)->send(new BookConfirm($mailData));


        $notification = array(
            'message' => 'Booking status updated successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function StoreUpdatedBookingDetails(Request $request, $id) {
        if($request->available_room < $request->number_of_rooms) {
            $notification = array(
                'message' => 'Number of rooms requested could not be fulfilled.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);            
        }


        $booking = Booking::findOrFail($id);
        $booking->number_of_rooms = $request->number_of_rooms;
        $booking->check_in = date('Y-m-d', strtotime($request->check_in));
        $booking->check_out = date('Y-m-d', strtotime($request->check_out));

        $booking->save();

        BookingRoomList::where('booking_id', $id)->delete();
        RoomBookedDate::where('booking_id', $id)->delete();

        $sDate = date('Y-m-d', strtotime($request->check_in));
        $eDate = date('Y-m-d', strtotime($request->check_out));
        $allDate = Carbon::create($eDate)->subDay();
        $dateRange = CarbonPeriod::create($sDate, $allDate);

        foreach($dateRange as $date) {
            $booked_dates = new RoomBookedDate();
            $booked_dates->booking_id = $booking->id;
            $booked_dates->room_id = $booking->room_id;
            $booked_dates->book_date = date('Y-m-d', strtotime($date));
            $booked_dates->save();
        }        

        $notification = array(
            'message' => 'Booking details updated successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);        
    }

    public function AssignRoom($id) {
        $booking = Booking::findOrFail($id);

        /*$booking_date_array = RoomBookedDate::where('booking_id', $id)->pluck('book_date')->toArray();

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $booking_date_array)->where('room_id', $booking->room_id)->distinct()->pluck('booking_id')->toArray();

        $booking_ids = Booking::whereIn('id', $check_date_booking_ids)->pluck('id')->toArray();

        $assign_room_ids = BookingRoomList::whereIn('booking_id', $booking_ids)->pluck('room_number_id')->toArray();

        $room_numbers = RoomNumber::where('room_id', $booking->room_id)->whereNotIn('id', $assign_room_ids)->where('status', 'Active')->get();*/


        $booking_date_array = RoomBookedDate::where('booking_id', $id)->pluck('book_date')->toArray();
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $booking_date_array)->where('room_id', $booking->room_id)->distinct()->pluck('booking_id')->toArray();

        $booking_ids = Booking::whereIn('id', $check_date_booking_ids)->pluck('id')->toArray();
        $assign_room_ids = BookingRoomList::whereIn('booking_id', $booking_ids)->pluck('room_number_id')->toArray();

        $room_numbers = RoomNumber::where('room_id', $booking->room_id)->whereNotIn('id', $assign_room_ids)->where('status', 'Active')->get();

        return view('backend.booking.assign_room', compact('booking', 'room_numbers'));
    }

    public function StoreAssignRoom($id, $room_number_id) {
        $booking = Booking::findOrFail($id);
        $check_data = BookingRoomList::where('booking_id', $id)->count();
        if($check_data < $booking->number_of_rooms) {
            $assign_data = new BookingRoomList();
            $assign_data->booking_id = $id;
            $assign_data->room_id = $booking->room_id;
            $assign_data->room_number_id = $room_number_id;
            $assign_data->save();    
            
 
            $notification = array(
                'message' => 'Room assigned successfully.',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);            
        } else {
            $notification = array(
                'message' => 'Room is unavailable for assignment.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);             
        }
    }

    public function DeleteAssignedRoom($id) {
        $assigned_room = BookingRoomList::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Assigned room has been removed.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);         
    }

    public function DownloadInvoice($id) {
        $booking = Booking::with('room')->findOrFail($id);

        $pdf = Pdf::loadView('backend.booking.booking_invoice', compact('booking'))
                ->setPaper('a4')
                ->setOption([
                    'tempDir' => public_path(),
                    'chroot' => public_path()
                ]);
        return $pdf->download('invoice.pdf');     
    }
}
