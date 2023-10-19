@extends('layouts.app')

@section('content')
<section class="page-content">
	<div class="row mt-5 ">

		<div class="col-lg-12 ">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Edit Profile</h3>
				</div>

				<div class="card-body">
					@if (session('msg'))
					<div class="alert alert-success" role="alert">
						{{ session('msg') }}
					</div>
					@endif
					<div class="row">
						<!-- <div class="col-md-3">
                             <?php if(isset($user->image) && $user->image !=''){  ?>
								<img src="<?php  echo $user->image; ?>" class="rounded-circle w-75 mx-4" id='profile_img' alt="Avatar" />
						<?php	 }else{  ?>
							<img src="<?php  echo asset('profile/profile.png'); ?>" class="rounded-circle w-75 mx-4" alt="Avatar" />

					<?php	} ?>
						<form enctype="multipart/form-data" >
							<input type="file" id="profile" class='d-none' />	
							<button type="button" class="btn btn-primary mx-5 mt-2 profile_image">Upload Image</button>
						</form>
						</div> -->
						<div class="col-md-12 ">
							<form id='form' action="{{route('profile.add')}}" method="post">
								@csrf
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">First Name</label>
											<input type="text" class="form-control  @error('first_name') is-invalid @enderror" name='first_name' value='{{Auth::user()->first_name}}' placeholder="First Name">
											@error('first_name')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">last Name</label>
											<input type="text" class="form-control  @error('last_name') is-invalid @enderror" name='last_name' value="{{Auth::user()->last_name}}" placeholder="Last Name">
											@error('last_name')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">Username</label>
											<input type="text" class="form-control  @error('username') is-invalid @enderror" value="{{Auth::user()->user_name}}" name='username' placeholder="Username">
											@error('username')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label class="form-label">Designation</label>
											<?php $designation = App\Models\Designation::where('id',Auth::user()->designation)->first();
											// dd(Auth::user()->designation);?>
											<input type="text" class="form-control" value='<?php echo $designation ==null ?' ':$designation->designation_name; ?>' readonly placeholder="Home Address">
										</div>
									</div>

									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">Mobile Number</label>
											<input type="text" class="form-control  @error('mobile') is-invalid @enderror" value='{{Auth::user()->mobile}}' name='mobile' placeholder="Mobile Number">
											@error('mobile')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>


									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">Email address</label>
											<input type="email" class="form-control" value='{{Auth::user()->email}}' placeholder="Email" readonly>
										</div>
									</div>
									
									<div class="col-md-12">
										<div class="form-group">
											<label class="form-label">Address</label>
											<input type="text" class="form-control  @error('address') is-invalid @enderror" value='{{isset($user->address) ? $user->address:""}}' name='address' placeholder="Home Address">
											@error('address')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-6 col-md-4">
										<div class="form-group">
											<label class="form-label">City</label>
											<input type="text" class="form-control  @error('city') is-invalid @enderror" value='{{isset($user->city) ? $user->city:""}}' name='city' placeholder="City">
											@error('city')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label">Postal Code</label>
											<input type="number" class="form-control  @error('postal') is-invalid @enderror" value='{{isset($user->pincode) ? $user->pincode:""}}' name='postal' placeholder="ZIP Code">
											@error('postal')
											<div class="error">*{{$message}}</div>
											@enderror
										</div>
									</div>

									


								</div>
						</div>

					</div>
				</div>
				<div class="card-footer text-right">
					<button type="submit" class="btn btn-primary">Update Profile</button>
				</div>
				</form>
			</div>
		</div>
	</div>

</section>
<script>
	            $('form[id="form"]').validate({
            ignore: 'input[type=hidden], .select2-input, .select2-focusser',
            rules: {
                first_name: 'required',
                last_name: 'required',
                username: 'required',
                mobile: 'required',
                address: {
                    required: true
                },
                city:'required',
                postal:'required',

            },
            messages: {
                first_name:'This First Name is Required',
                last_name:'This Last Name is Required',
                username:'This Username is Required',
                mobile:'This Mobile is Required',
                address:'This Address is Required',
                city:'This City is Required',
                postal:'This Postal is Required',

            },
            errorPlacement: function(label, element) {
                label.addClass('mt-2 text-danger');
                label.insertAfter(element);
            },
            highlight: function(element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('has-danger')
                $(element).parent().removeClass('form-control-danger')
            },
            submitHandler: function(form) {

                form.submit();
            }

        });

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('.profile_image').on('click', function() {
		$('#profile').trigger('click');
	});

	$('#profile').change(function() {
		
		var image_upload = new FormData();
		image_upload.append('image', $('input[type=file]')[0].files[0]);
		$.ajax({
			method: 'POST',
			url: "{{route('user.upload')}}",
			data: image_upload,
			contentType: false,
			processData: false,
			success: function(images) {
					 $("#profile_img").prop('src',images.image);
					 $(".avatar").prop('src',images.image);

			},
		});
	});
</script>
@endsection

