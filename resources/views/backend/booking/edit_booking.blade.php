@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-5">
                   <div class="col">
					 <div class="card radius-10 border-start border-0 border-3 border-info">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<p class="mb-0 text-secondary">Booking No#</p>
									<h4 class="my-1 text-info">{{ $booking->invoice_no }}</h4>
								</div>
								<div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
								</div>
							</div>
						</div>
					 </div>
				   </div>
				   <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-danger">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Booking Date</p>
								   <h4 class="my-1 text-danger">{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y') }}</h4>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bxs-wallet'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-success">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Payment Method</p>
								   <h4 class="my-1 text-success">{{ $booking->payment_method }}</h4>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-warning">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Payment Status</p>
								   <h4 class="my-1 text-warning">
                                        @if($booking->payment_status == '1')
                                            <span class="text-success">Completed</span>
                                        @else
                                            <span class="text-danger">Pending</span>
                                        @endif
                                   </h4>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div> 
				  <div class="col">
					<div class="card radius-10 border-start border-0 border-3 border-warning">
					   <div class="card-body">
						   <div class="d-flex align-items-center">
							   <div>
								   <p class="mb-0 text-secondary">Booking Status</p>
								   <h4 class="my-1 text-warning">
                                        @if($booking->status == '1')
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Pending</span>
                                        @endif 
                                   </h4>
							   </div>
							   <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
							   </div>
						   </div>
					   </div>
					</div>
				  </div>                   
				</div><!--end row-->

				<div class="row">
                   <div class="col-12 col-lg-8 d-flex">
                      <div class="card radius-10 w-100">
						  <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Room Type</th>
                                                <th>Total Room</th>
                                                <th>Price</th>
                                                <th>Check In/Out Date</th>
                                                <th>Total Days</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $booking['room']['type']['name'] }}</td>
                                                <td>{{ $booking->number_of_rooms }}</td>
                                                <td>{{ $booking->room->price }}</td>
                                                <td>{{ $booking->check_in }} / {{ $booking->check_out }}</td>
                                                <td>{{ $booking->total_stay }}</td>
                                                <td>{{ $booking->actual_price * $booking->number_of_rooms }}</td>
                                            </tr>                                            
                                        </tbody>
                                    </table>

									<div class="col-md-6" style="float: right;">
										<style>
											.test_table td {text-align: right;}
										</style>
										<table class="table test_table" style="float: right; border:none;">
											<tr>
												<td>Subtotal</td>
												<td>{{ $booking->subtotal }}</td>
											</tr>
											<tr>
												<td>Discount</td>
												<td>{{ $booking->discount }}</td>
											</tr>	
											<tr>
												<td>Grand Total</td>
												<td>{{ $booking->total_price }}</td>
											</tr>																					
										</table>
									</div>

                                </div>

								<form action="">
									<div class="row" style="margin-top: 40px;">
										<div class="col-md-5">
											<label for="payment_status">Payment Status</label>
                                            <select name="payment_status" class="form-select">
                                                <option selected="">Select status...</option>
                                                <option value="0" {{$booking->payment_status == 0?'selected':''}}>Pending</option>
                                                <option value="1" {{$booking->payment_status == 1?'selected':''}}>Completed</option>
                                            </select>											
										</div>
										<div class="col-md-5">
											<label for="status">Booking Status</label>
                                            <select name="status" class="form-select">
                                                <option selected="">Select status...</option>
                                                <option value="0" {{$booking->status == 0?'selected':''}}>Pending</option>
                                                <option value="1" {{$booking->status == 1?'selected':''}}>Completed</option>
                                            </select>											
										</div>
										<div class="col-md-12" style="margin-top:20px;">
											<button type="submit" class="btn btn-primary">Update</button>
										</div>										
									</div>
								</form>


						  </div>
					  </div>
				   </div>
				   <div class="col-12 col-lg-4">
                       <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Manage Room and Date</h6>
								</div>
							</div>
						</div>
						   <div class="card-body">
								<form action="">
									<div class="row">
										<div class="col-md-12 mb-2">
											<label for="">Check-In</label>
											<input type="date" required name="check_in" class="form-control" value="{{ $booking->check_in }}"/>
										</div>
										<div class="col-md-12 mb-2">
											<label for="">Check-out</label>
											<input type="date" name="check_out" class="form-control" value="{{ $booking->check_out }}"/>
										</div>	
										<div class="col-md-12 mb-2">
											<label for="">Room</label>
											<input type="number" name="number_of_rooms" class="form-control" value="{{ $booking->number_of_rooms }}"/>
										</div>	
											<div class="col-md-12 mb-2">
											<label for="">Availability : <span class="text-success availability"></span></label>
										</div>	
										<div class="mt-2">
											<button type="submit" class="btn btn-primary">Update</button>
										</div>																																					
									</div>
								</form>
						   </div>
					   </div>
                       <div class="card radius-10 w-100">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Customer Information</h6>
								</div>
							</div>
						</div>
						   <div class="card-body">
								<form action="">
									<div class="row">
										<label for="">Name : {{ $booking->user->name }}</label><br/>
										<label for="" class="my-2">Email : {{ $booking->user->email }}</label><br/>	
										<label for="" class="my-2">Phone : {{ $booking->user->phone }}</label><br/>	
										<label for="" class="my-2">Country : {{ $booking->user->country }}</label><br/>	
										<label for="" class="my-2">State : {{ $booking->user->state }}</label><br/>
										<label for="" class="my-2">Zip Code : {{ $booking->user->zip_code }}</label><br/>
										<label for="" class="my-2">Address : {{ $booking->user->address }}</label><br/>																																
									</div>
								</form>
						   </div>
					   </div>					   
				   </div>
				</div><!--end row-->

			</div>

@endsection