@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit Room Number</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Room Number</li>
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
									<form id="myForm" action="{{ route('room.number.update.store') }}" method="post">
										@csrf
                                        <input type="hidden" name="id" value="{{ $roomNumber->id }}" />
										<div class="card-body">
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Room Number</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="room_no" value="{{ $roomNumber->room_no }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Status</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
                                                    <select name="status" class="form-select">
                                                        <option selected="">Select status...</option>
                                                        <option value="Active" {{$roomNumber->status == 'Active'?'selected':''}}>Active</option>
                                                        <option value="Inactive" {{$roomNumber->status == 'Inactive'?'selected':''}}>Inactive</option>
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
                room_no: {
                    required : true,
                }, 
                status: {
                    required : true,
                },						                
            },
            messages :{
                room_no: {
                    required : 'Please Enter Room Number',
                }, 
                status: {
                    required : 'Please Enter Status',
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