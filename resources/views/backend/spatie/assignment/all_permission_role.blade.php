@extends('admin.admin_dashboard')
@section('admin')

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Permission Role</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Permission Role</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Action</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="{{ route('add.permission.role') }}">Add Permission Role</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All Permission Role</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No#</th>
										<th>Role Name</th>
										<th>Permission</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($roles as $key=> $item)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $item->name }}</td>
										<td>
                                            @foreach($item->permissions as $permission)
                                            <span class="badge bg-danger">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
										<td>
											<a href="{{ route('edit.permission.role', $item->id) }}" class="btn btn-warning px-3 radius-30">Edit</a>
											<a href="{{ route('delete.permission.role', $item->id) }}" class="btn btn-danger px-3 radius-30" id="delete">Delete</a>
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