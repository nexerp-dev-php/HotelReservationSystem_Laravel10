@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Add BookArea</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add BookArea</li>
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
									<form id="myForm" action="{{ route('book.area.store') }}" method="post" enctype="multipart/form-data">
										@csrf
										<div class="card-body">
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Short Title</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="short_title" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Main Title</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="main_title" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Short Description</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
                                                    <textarea name="short_desc" rows="4" style="width: 100%;box-sizing: border-box;padding: 5px;border: 1px solid #ccc;"></textarea>
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Link URL</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="text" class="form-control" name="link_url" />
												</div>
											</div>                                            
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0">Photo</h6>
												</div>
												<div class="form-group col-sm-9 text-secondary">
													<input type="file" class="form-control" name="image" id="image" />
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-sm-3">
													<h6 class="mb-0"></h6>
												</div>
												<div class="col-sm-9 text-secondary">
													<img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="80">
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
$(document).ready(function() {
	$('#image').change(function(e) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#showImage').attr('src', e.target.result);
		}
		reader.readAsDataURL(e.target.files[0]);
	});
});
</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                short_title: {
                    required : true,
                }, 
                main_title: {
                    required : true,
                },
                short_desc: {
                    required : true,
                },
                link_url: {
                    required : true,
                },                
                image: {
                    required : true,
                },								                
            },
            messages :{
                short_title: {
                    required : 'Please Enter Short Title',
                }, 
                main_title: {
                    required : 'Please Enter Main Title',
                },                 
                short_desc: {
                    required : 'Please Enter Short Description',
                },
                link_url: {
                    required : 'Please Enter Link URL',
                },                
                image: {
                    required : 'Please Select An Image',
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