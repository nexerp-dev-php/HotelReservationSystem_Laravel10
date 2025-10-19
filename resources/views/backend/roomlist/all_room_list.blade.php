@extends('admin.admin_dashboard')
@section('admin')

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Room List</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Room List</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Action</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="{{ route('add.room.booking') }}">Add Booking</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All Room List</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No#</th>
										<th>Room Type</th>
										<th>Room Number</th>
										<th>Booking Status</th>
										<th>Check In/Out Date</th>
                                        <th>Booking No#</th>
                                        <th>Customer</th>
                                        <th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($room_number_list as $key=> $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $item->name }}</td>
										<td>{{ $item->room_no }}</td>
										<td>
                                            @if($item->booking_id != '')
                                                @if($item->booking_status == 1)
                                                    <span class="badge bg-danger">Booked</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge bg-success">Available</span>
                                            @endif
                                        </td>
										<td>
                                            @if($item->booking_id != '')
                                                <span class="badge bg-danger">{{ date('d-m-Y', strtotime($item->check_in)) }}</span> / 
                                                <span class="badge bg-danger">{{ date('d-m-Y', strtotime($item->check_out)) }}</span>
                                            @endif                                            
                                        </td>
                                        <td>
                                            @if($item->booking_id != '')
                                                {{ $item->booking_no }}
                                            @endif                                              
                                        </td>
                                        <td>
                                            @if($item->booking_id != '')
                                                {{ $item->customer_name }}
                                            @endif                                             
                                        </td>
                                        <td>
                                            @if($item->status == 'Active')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif                                            
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