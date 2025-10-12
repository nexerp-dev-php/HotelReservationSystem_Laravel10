@extends('frontend.main_master')
@section('main')

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg9">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>Rooms</li>
                    </ul>
                    <h3>Rooms</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

        <!-- Room Area -->
        <div class="room-area pt-100 pb-70">
            <div class="container">
                <div class="section-title text-center">
                    <span class="sp-color">ROOMS</span>
                    <h2>Our Rooms & Rates</h2>
                </div>
                <div class="row pt-45">
                    @php
                        $empty_array = [];
                    @endphp

                    @foreach($rooms as $room)

                    @php
                        $bookings = App\Models\Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('room_id', $room->id)->get()->toArray();

                        $total_booked_room = array_sum(array_column($bookings, 'assign_rooms'));

                        $remaining_room = $room->room_numbers_count - $total_booked_room;
                    @endphp

                    <!--"old" is a built-in function to retrieve previously submitted data-->
                    @if($remaining_room > 0 && old('person') <= $room->total_adult)
                    <div class="col-lg-6 col-md-6">
                        <div class="room-card">
                            <a href="{{ route('show.room', $room->id) }}">
                                <img src="{{asset('upload/room/'.$room->image)}}" alt="Images" style="width:100%;height:450px;">
                            </a>
                            <div class="content">
                                <h3><a href="{{ route('show.room', $room->id) }}">{{ $room->type->name }}</a></h3>
                                <ul>
                                    <li class="text-color">{{ $room->price }}</li>
                                    <li class="text-color">Per Night</li>
                                </ul>
                                <div class="rating text-color">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star-half'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        @php
                        array_push($empty_array, $room->id)
                        @endphp
                    @endif
                    @endforeach

                    @if(count($rooms) == count($empty_array))
                    <p class="text-center text-danger">No result found.</p>
                    @endif

                </div>
            </div>
        </div>
        <!-- Room Area End -->

@endsection