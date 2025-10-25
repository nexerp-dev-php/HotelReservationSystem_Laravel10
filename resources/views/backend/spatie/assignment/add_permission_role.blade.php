@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Role Permission Assignment</div>
					<div class="ps-3">
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<form id="myForm" action="{{ route('permission.role.store') }}" method="post">
										@csrf
										<div class="card-body">
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Role</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<select class="form-control form-select mb-3" name="role">
														<option value="" disabled>Select Group</option>
                                                        @foreach($roles as $role)
														<option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
													</select>
												</div>
											</div>
											<div class="row mb-3">
												<div class="form-group col-sm-12 text-secondary">
                                                    <input class="form-check-input mb-3" type="checkbox" value="" id="allPermission">
                                                    <label class="form-check-label mb-3" for="allPermission">All Permissions</label>
												</div>
											</div>	
											
											<hr/>

											@foreach($permission_groups as $group)
											<div class="row">
												<div class="col-3">
													<div class="form-group col-sm-12 text-secondary">
														<label class="form-check-label mb-3">{{ $group->group_name }}</label>
													</div>
												</div>
												<div class="col-9">
													@php
														$permissions = App\Models\User::getPermissionByGroupName($group->group_name);
													@endphp

													@foreach($permissions as $permission)
													<div class="form-group col-sm-12 text-secondary">
														<input class="form-check-input mb-3" type="checkbox" name="permission[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}">
														<label class="form-check-label mb-3" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
													</div>	
													<br/>
													@endforeach							
												</div>
											</div>
											@endforeach

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
		$('#allPermission').click(function(){
			if($(this).is(':checked')) {
				$('input[ type=checkbox ]').prop('checked', true);
			} else {
				$('input[ type=checkbox ]').prop('checked', false);
			}
		})


        $('#myForm').validate({
            rules: {
                role: {
                    required : true,
                }, 					                
            },
            messages :{
                role: {
                    required : 'Please Enter Name',
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