@extends('admin.admin_dashboard')
@section('admin')

<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit Room</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Room</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">



                        <div class="card">
							<div class="card-body">
								<ul class="nav nav-tabs nav-primary" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
												</div>
												<div class="tab-title">Room Info</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false" tabindex="-1">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
												</div>
												<div class="tab-title">Room Number</div>
											</div>
										</a>
									</li>
								</ul>
								<div class="tab-content py-3">
									<div class="tab-pane fade show active" id="primaryhome" role="tabpanel">


                                        <div class="card">
                                            <div class="card-body p-4">
                                                <h5 class="mb-4">{{ $room->type->name }}</h5>
                                                <form id="myForm" class="row g-3" action="{{ route('room.store', $room->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-md-6">
                                                        <label for="input1" class="form-label">Total Adult</label>
                                                        <input type="text" class="form-control" name="total_adult" id="total_adult" value="{{ $room->total_adult }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="input2" class="form-label">Total Child</label>
                                                        <input type="text" class="form-control" name="total_child" id="total_child" value="{{ $room->total_child }}">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="input3" class="form-label">Main Image</label>
                                                        <input type="file" class="form-control" name="image" id="image">
                                                        <img id="showImage" src="{{ (!empty($room->image)) ? url('upload/room/'.$room->image) : url('upload/no_image.jpg') }}" alt="Admin" class="bg-primary" width="100" height="80">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="input4" class="form-label">Gallery Image</label>
                                                        <input type="file" class="form-control" name="multi_img[]" id="multiImg" multiple>
                                                        
                                                        @foreach($gallery_images as $gallery_image)
                                                        <img src="{{ (!empty($gallery_image->multi_img)) ? url('upload/room/'.$gallery_image->multi_img) : url('upload/no_image.jpg') }}" class="bg-primary" width="100" height="80">
                                                        <a href="{{ route('delete.room.gallery.image', $gallery_image->id) }}"><i class="lni lni-close"></i></a>
                                                        @endforeach
                                                        
                                                        <div class="row" id="preview_img"></div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="input1" class="form-label">Room Price</label>
                                                        <input type="text" class="form-control" name="price" id="price" value="{{ $room->price }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="input2" class="form-label">Discount (%)</label>
                                                        <input type="text" class="form-control" name="discount" id="discount" value="{{ $room->discount }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="input2" class="form-label">Size</label>
                                                        <input type="text" class="form-control" name="size" id="size" value="{{ $room->size }}">
                                                    </div>                                                    
                                                    <div class="col-md-3">
                                                        <label for="input1" class="form-label">Room capacity</label>
                                                        <input type="text" class="form-control" name="room_capacity" id="room_capacity" value="{{ $room->room_capacity }}">
                                                    </div> 
                                                    
                                                    <div class="col-md-6">
                                                        <label for="input7" class="form-label">Room View {{$room->view}}</label>
                                                        <select name="view" id="view" class="form-select">
                                                            <option selected="">Choose...</option>
                                                            <option value="Sea View" {{$room->view == 'Sea View'?'selected':''}}>Sea View</option>
                                                            <option value="Hill View" {{$room->view == 'Hill View'?'selected':''}}>Hill View</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="input7" class="form-label">Bed Style {{$room->bed_type}}</label>
                                                        <select name="bed_type" id="bed_type" class="form-select">
                                                            <option selected="">Choose...</option>
                                                            <option value="Queen Bed" {{$room->bed_type == 'Queen Bed'?'selected':''}}>Queen Bed</option>
                                                            <option value="Twin Bed" {{$room->bed_type == 'Twin Bed'?'selected':''}}>Twin Bed</option>
                                                            <option value="King Bed" {{$room->bed_type == 'King Bed'?'selected':''}}>King Bed</option>
                                                        </select>
                                                    </div>                                                                                                        

                                                    <div class="col-md-12">
                                                        <label for="input11" class="form-label">Short Description</label>
                                                        <textarea class="form-control" name="short_desc" id="short_desc" rows="3">{{ $room->short_desc }}</textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="input11" class="form-label">Full Description</label>
                                                        <textarea class="form-control" name="description" id="description" rows="3">{{ $room->description }}</textarea>
                                                    </div>                                                                                                        
                                                    





 <div class="row mt-2">
 <div class="col-md-12 mb-3">
    @forelse ($basic_facility as $item)
    <div class="basic_facility_section_remove" id="basic_facility_section_remove">
       <div class="row add_item">
          <div class="col-md-8">
             <label for="facility_name" class="form-label"> Room Facilities </label>
             <select name="facility_name[]" id="facility_name" class="form-control">
                   <option value="">Select Facility</option>
                   <option value="Complimentary Breakfast" {{$item->facility_name == 'Complimentary Breakfast'?'selected':''}}>Complimentary Breakfast</option>
  <option value="32/42 inch LED TV"  {{$item->facility_name == 'Complimentary Breakfast'?'selected':''}}> 32/42 inch LED TV</option>

 <option value="Smoke alarms"  {{$item->facility_name == 'Smoke alarms'?'selected':''}}>Smoke alarms</option>

 <option value="Minibar" {{$item->facility_name == 'Complimentary Breakfast'?'selected':''}}> Minibar</option>

 <option value="Work Desk"  {{$item->facility_name == 'Work Desk'?'selected':''}}>Work Desk</option>

 <option value="Free Wi-Fi" {{$item->facility_name == 'Free Wi-Fi'?'selected':''}}>Free Wi-Fi</option>

 <option value="Safety box" {{$item->facility_name == 'Safety box'?'selected':''}} >Safety box</option>

 <option value="Rain Shower" {{$item->facility_name == 'Rain Shower'?'selected':''}} >Rain Shower</option>

 <option value="Slippers" {{$item->facility_name == 'Slippers'?'selected':''}} >Slippers</option>

 <option value="Hair dryer" {{$item->facility_name == 'Hair dryer'?'selected':''}} >Hair dryer</option>

 <option value="Wake-up service"  {{$item->facility_name == 'Wake-up service'?'selected':''}}>Wake-up service</option>

 <option value="Laundry & Dry Cleaning" {{$item->facility_name == 'Laundry & Dry Cleaning'?'selected':''}} >Laundry & Dry Cleaning</option>
 
 <option value="Electronic door lock"  {{$item->facility_name == 'Electronic door lock'?'selected':''}}>Electronic door lock</option> 
             </select>
          </div>
          <div class="col-md-4">
             <div class="form-group" style="padding-top: 30px;">
         <a class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></a>

        <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
             </div>
          </div>
       </div>
    </div>

    @empty

         <div class="basic_facility_section_remove" id="basic_facility_section_remove">
             <div class="row add_item">
                 <div class="col-md-6">
                     <label for="basic_facility_name" class="form-label">Room Facilities </label>
                     <select name="facility_name[]" id="basic_facility_name" class="form-control">
 <option value="">Select Facility</option>
 <option value="Complimentary Breakfast">Complimentary Breakfast</option>
 <option value="32/42 inch LED TV" > 32/42 inch LED TV</option>
 <option value="Smoke alarms" >Smoke alarms</option>
 <option value="Minibar"> Minibar</option>
 <option value="Work Desk" >Work Desk</option>
 <option value="Free Wi-Fi">Free Wi-Fi</option>
 <option value="Safety box" >Safety box</option>
 <option value="Rain Shower" >Rain Shower</option>
 <option value="Slippers" >Slippers</option>
 <option value="Hair dryer" >Hair dryer</option>
 <option value="Wake-up service" >Wake-up service</option>
 <option value="Laundry & Dry Cleaning" >Laundry & Dry Cleaning</option>
 <option value="Electronic door lock" >Electronic door lock</option> 
                     </select>
                 </div>
                 <div class="col-md-6">
                     <div class="form-group" style="padding-top: 30px;">
         <a class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></a>

        <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
                     </div>
                 </div>
             </div>
         </div>

    @endforelse



                     </div> 
                  </div>
                  <br>




                                                    <div class="col-md-12">
                                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                                                            <button type="reset" class="btn btn-light px-4">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


									</div>
									<div class="tab-pane fade" id="primaryprofile" role="tabpanel">
										<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
									</div>
								</div>
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
                total_adult: {
                    required : true,
                }, 
                total_child: {
                    required : true,
                },
                price: {
                    required : true,
                },
                discount: {
                    required : true,
                },
                size: {
                    required : true,
                }, 
                room_capacity: {
                    required : true,
                },
                short_desc: {
                    required : true,
                },
                description: {
                    required : true,
                },	                								                
            },
            messages :{
                total_adult: {
                    required : 'Please Enter Total Adult',
                }, 
                total_child: {
                    required : 'Please Enter Total Child',
                },                 
                price: {
                    required : 'Please Enter Price',
                },
                discount: {
                    required : 'Please Enter Discount',
                },	
                size: {
                    required : 'Please Enter Size',
                }, 
                room_capacity: {
                    required : 'Please Enter Room Capacity',
                },                 
                short_desc: {
                    required : 'Please Enter Short Description',
                },
                description: {
                    required : 'Please Enter Full Decription',
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

<!--------===Show MultiImage ========------->
<script>
   $(document).ready(function(){
    $('#multiImg').on('change', function(){ //on file input change
       if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
       {
           var data = $(this)[0].files; //this file data
            
           $.each(data, function(index, file){ //loop though each file
               if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                   var fRead = new FileReader(); //new filereader
                   fRead.onload = (function(file){ //trigger function on successful read
                   return function(e) {
                       var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                   .height(80); //create image element 
                       $('#preview_img').append(img); //append image to output element
                   };
                   })(file);
                   fRead.readAsDataURL(file); //URL representing the file's data.
               }
           });
            
       }else{
           alert("Your browser doesn't support File API!"); //if File API is absent
       }
    });
   });
</script>

<!--========== Start of add Basic Plan Facilities ==============-->
<div style="visibility: hidden">
   <div class="whole_extra_item_add" id="whole_extra_item_add">
      <div class="basic_facility_section_remove" id="basic_facility_section_remove">
         <div class="container mt-2">
            <div class="row">
               <div class="form-group col-md-6">
                  <label for="basic_facility_name">Room Facilities</label>
                  <select name="facility_name[]" id="basic_facility_name" class="form-control">
                        <option value="">Select Facility</option>
 <option value="Complimentary Breakfast">Complimentary Breakfast</option>
 <option value="32/42 inch LED TV" > 32/42 inch LED TV</option>
 <option value="Smoke alarms" >Smoke alarms</option>
 <option value="Minibar"> Minibar</option>
 <option value="Work Desk" >Work Desk</option>
 <option value="Free Wi-Fi">Free Wi-Fi</option>
 <option value="Safety box" >Safety box</option>
 <option value="Rain Shower" >Rain Shower</option>
 <option value="Slippers" >Slippers</option>
 <option value="Hair dryer" >Hair dryer</option>
 <option value="Wake-up service" >Wake-up service</option>
 <option value="Laundry & Dry Cleaning" >Laundry & Dry Cleaning</option>
 <option value="Electronic door lock" >Electronic door lock</option> 
                  </select>
               </div>
               <div class="form-group col-md-6" style="padding-top: 20px">
                  <span class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></span>
                  <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function(){
      var counter = 0;
      $(document).on("click",".addeventmore",function(){
            var whole_extra_item_add = $("#whole_extra_item_add").html();
            $(this).closest(".add_item").append(whole_extra_item_add);
            counter++;
      });
      $(document).on("click",".removeeventmore",function(event){
            $(this).closest("#basic_facility_section_remove").remove();
            counter -= 1
      });
   });
</script>
<!--========== End of Basic Plan Facilities ==============-->


@endsection