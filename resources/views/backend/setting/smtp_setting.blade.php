@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit SMTP Setting</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit SMTP Setting</li>
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
									<form id="myForm" action="{{ route('smtp.setting.store') }}" method="post">
										@csrf
                                        <input type="hidden" name="id" value="{{ $smtp->id }}" />
										<div class="card-body">
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Mailer</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="mailer" value="{{ $smtp->mailer }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Host</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="host" value="{{ $smtp->host }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Port</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="number" class="form-control" name="port" value="{{ $smtp->port }}" />
												</div>
											</div>	
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Username</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="username" value="{{ $smtp->username }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Password</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="password" class="form-control" name="password" value="{{ $smtp->password }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Encryption</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="encryption" value="{{ $smtp->encryption }}" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Sender</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="sender" value="{{ $smtp->sender }}" />
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
                mailer: {
                    required : true,
                }, 
                host: {
                    required : true,
                },
                port: {
                    required : true,
                },	
                username: {
                    required : true,
                }, 
                password: {
                    required : true,
                },
                encryption: {
                    required : true,
                },	
                sender: {
                    required : true,
                },                 
            },
            messages :{
                mailer: {
                    required : 'Please Enter Mailer',
                }, 
                host: {
                    required : 'Please Enter Host',
                },                 
                port: {
                    required : 'Please Enter Port',
                },
                username: {
                    required : 'Please Enter Username',
                }, 
                password: {
                    required : 'Please Enter Password',
                },                 
                encryption: {
                    required : 'Please Enter Encryption',
                },	
               sender: {
                    required : 'Please Enter Sender',
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