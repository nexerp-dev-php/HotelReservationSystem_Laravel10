@extends('frontend.main_master')
@section('main')

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg6">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Booking Details</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>Update Profile </li>
                    </ul>
                    <h3>Update Profile</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

        <!-- Service Details Area -->
        <div class="service-details-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                     <div class="col-lg-3">
                    @include('frontend.dashboard.user_menu')
                    </div>


                    <div class="col-lg-9">
                        <div class="service-article">
                            
 
            <section class="checkout-area pb-70">
            <div class="container">
                <form action="{{ route('password.change.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-details">
                                <h3 class="title">Booking Details</h3>

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col">Booking No#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Room</th>
                                        <th scope="col">Check In/out</th>
                                        <th scope="col">Total Room</th>
                                        <th scope="col">Guest</th>
                                        <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                        <tr>
                                            <th scope="row"><a href="{{ route('user.invoice', $booking->id) }}">{{ $booking->invoice_no }}</a></th>
                                            <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>{{ $booking->room->type->name }}</td>
                                            <td>{{ date('d-m-Y', strtotime($booking->check_in)) }} / {{ date('d-m-Y', strtotime($booking->check_out)) }}</td>
                                            <td>{{ $booking->number_of_rooms }}</td>
                                            <td>{{ $booking->person }}</td>
                                            <td>
                                                @if($booking->status == 1)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                

                            </div>
                        </div>
                    </div>
                </form>      
                
            </div>
            </section>
                            
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
        <!-- Service Details Area End -->

@endsection