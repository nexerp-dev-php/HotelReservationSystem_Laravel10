@extends('admin.admin_dashboard')
@section('admin')

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Booking</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Booking</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Action</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="{{ route('add.team') }}">Add Booking</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All Booking</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No#</th>
										<th>Booking No#</th>
										<th>Booking Date</th>
										<th>Customer</th>
										<th>Room</th>
                                        <th>Check-In/Out</th>
                                        <th>Total Room</th>
                                        <th>Guest</th>
                                        <th>Payment</th>
                                        <th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($bookings as $key=> $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td><a href="{{ route('edit.booking', $item->id) }}">{{ $item->invoice_no }}</a></td>
										<td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $item['user']['name'] }}</td>
										<td>{{ $item['room']['type']['name'] }}</td>
										<td>{{ $item->check_in }} /<br/>{{ $item->check_out }}</td>
                                        <td>{{ $item->number_of_rooms }}</td>
                                        <td>{{ $item->person }}</td>
                                        <td>
                                            @if($item->payment_status == '1')
                                                <span class="text-success">Completed</span>
                                            @else
                                                <span class="text-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == '1')
                                                <span class="text-success">Active</span>
                                            @else
                                                <span class="text-danger">Pending</span>
                                            @endif                                            
                                        </td>
										<td>
											<a href="{{ route('delete.team', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

@endsection