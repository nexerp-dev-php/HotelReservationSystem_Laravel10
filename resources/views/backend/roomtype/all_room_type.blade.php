@extends('admin.admin_dashboard')
@section('admin')

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Room Types</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Room Types</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Action</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                <a class="dropdown-item" href="{{ route('add.room.type') }}">Add Room Type</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All Room Types</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No#</th>
										<th>Image</th>
										<th>Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($roomtypes as $key=> $item)
									@php
										$room = App\models\Room::where('roomtype_id', $item->id)
									@endphp
									<tr>
										<td>{{ $key+1 }}</td>
										<td><img src="{{ (!empty($item->room->image)) ? url('upload/room/'.$item->room->image) : url('upload/no_image.jpg') }}" width="100" height="80"></td>
										<td>{{ $item->name }}</td>
										<td>
											<a href="{{ route('edit.room.type', $item->id) }}" class="btn btn-warning px-3 radius-30">Edit</a>
											<a href="{{ route('delete.room.type', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Delete</a> | 
											<a href="{{ route('edit.room', $item->room->id) }}" class="btn btn-success px-3 radius-30">Edit Room Info</a>
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