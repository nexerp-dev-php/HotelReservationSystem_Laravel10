@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit Permission</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
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
									<form id="myForm" action="{{ route('permission.update.store') }}" method="post">
										@csrf
                                        <input type="hidden" name="id" value="{{ $permission->id }}" />
										<div class="card-body">
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Name</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="name" value="{{ $permission->name }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Group Name</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<select class="form-control form-select mb-3" name="group_name">
														<option value="">Select Group</option>
														<option value="Team" {{ $permission->group_name == 'Team' ? 'selected' : '' }}>Team</option>
														<option value="Book Area" {{ $permission->group_name == 'Book Area' ? 'selected' : '' }}>Book Area</option>
														<option value="Manage Room" {{ $permission->group_name == 'Manage Room' ? 'selected' : '' }}>Manage Room</option>
														<option value="Booking" {{ $permission->group_name == 'Booking' ? 'selected' : '' }}>Booking</option>
														<option value="Room List" {{ $permission->group_name == 'Room List' ? 'selected' : '' }}>Room List</option>
														<option value="Testimonial" {{ $permission->group_name == 'Testimonial' ? 'selected' : '' }}>Testimonial</option>
														<option value="Role and Permission" {{ $permission->group_name == 'Role and Permission' ? 'selected' : '' }}>Role and Permission</option>
													</select>													
												</div>
											</div>								
											<div class="row">
												<div class="col-sm-3"></div>
												<div class="col-sm-9 text-secondary">
													<input type="submit" class="btn btn-primary px-4" value="Save Changes" />
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                group_name: {
                    required : true,
                },
                guard_name: {
                    required : true,
                },							                
            },
            messages :{
                name: {
                    required : 'Please Enter Name',
                }, 
                group_name: {
                    required : 'Please Enter Group Name',
                },                 
                guard_name: {
                    required : 'Please Enter Guard Name',
                },			
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>

@endsection