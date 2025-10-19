@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Add Booking</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add Booking</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body p-4">
                                        <form class="row g-3" method="post" action="{{ route('store.room.booking') }}">
                                            @csrf
                                            <div class="col-md-4">
                                                <label for="roomtype_id" class="form-label">Room Type</label>
                                                <select id="room_id" name="room_id" class="form-select">
                                                    <option>Select Room Type</option>
                                                    @foreach($roomtype as $item)
                                                    <option value="{{ $item->room->id }}" {{ collect(old('roomtype_id'))->contains($item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="check_in" class="form-label">Check-In</label>
                                                <input type="date" class="form-control" id="check_in" name="check_in">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="check_out" class="form-label">Check-Out</label>
                                                <input type="date" class="form-control" id="check_out" name="check_out">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="number_of_rooms" class="form-label">Room</label>
                                                <input type="number" class="form-control" id="number_of_rooms" name="number_of_rooms">
                                                <input type="hidden" name="available_room" id="available_room" class="form-control"/>
                                                <div class="mt-2">
                                                    <label for="">Availability : <span class="text-success availability"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="person" class="form-label">Guest</label>
                                                <input type="text" class="form-control" id="person" name="person">
                                            </div>

                                            <h3 class="mt-3 mb-5 text center">Customer Information</h3>

                                            <div class="col-md-4">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                            </div> 

                                            <div class="col-md-4">
                                                <label for="country" class="form-label">Country</label>
                                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                                            </div>   
                                            <div class="col-md-4">
                                                <label for="state" class="form-label">State</label>
                                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}">
                                            </div> 
                                            <div class="col-md-4">
                                                <label for="zip_code" class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}">
                                            </div>                                                                                                                                    

                                            <div class="col-md-12">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

							</div>
						</div>
					</div>
				</div>
			</div>

<script>
	$(document).ready(function () {

		function getAvailability() {
			var check_in = $('#check_in').val();
			var check_out = $('#check_out').val();
			var room_id = $('#room_id').val();

            var startDate = new Date(check_in);
            var endDate = new Date(check_out);

            if(startDate > endDate) {
                alert('Invalid date');
                $('#check_out').val('');
                return false;
            }

            if(check_in != '' && check_out != '' && room_id != '') {
                $.ajax({
                    url: "{{ route('check.room.availability') }}",
                    data: {room_id:room_id, check_in:check_in, check_out:check_out},
                    success: function(data){
                        $(".availability").html('<span class="text-success">'+data['available_room']+' Rooms</span>');
                        $("#available_room").val(data['available_room']);
                    }
                });	
            }	
		}

        $("#room_id").on('change', function() {
			$('#check_in').val('');
			$('#check_out').val('');
            $('.availability').text(0);
            $('#available_room').val(0);
        });

        $("#check_out").on('change', function() {
			getAvailability();
        });

		

    })
 </script>

@endsection