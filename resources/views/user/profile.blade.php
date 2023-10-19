@extends('layouts.app')


@section('content')

		<div class="page">
			<!-- MODEl PART START HERE -->
			<div class="modal fade" id="imageupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-warning p-3">
							<h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Upload image</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="uploadform" method="post" enctype="multipart/form-data">
								<input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}" />
								<div class="row">
								<div class="form-group col-sm-12">
									<label>Image: </label>
									<input class="form-control" type="file" name="file"  />
								</div>
							</div>
						<!-- <button type="submit" class="btn btn-success btn-sm">Upload</button> -->
						</div>
						<div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm">Save</button>
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>

						</div>
						</form>
					</div>
				</div>
			</div>
			<?php /*
			<div class="modal fade" id="editaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-warning p-3">
							<h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Edit Account</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="editaccform" method="post" enctype="multipart/form-data">
								<input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}" />
								<div class="row">
									<div class="form-group col-sm-6">
										<label>Username: </label>
										<input class="form-control" type="" value="{{$users['name']}}" name="user_name"  />
									</div>
									<div class="form-group col-sm-6">
										<label>First Name: </label>
										<input class="form-control" type="" value="{{$users['name']}}" name="first_name"  />
									</div>
									<div class="form-group col-sm-6">
										<label>Last Name: </label>
										<input class="form-control" type="last_name" value="{{$users['name']}}" name="last_name"  />
									</div>
									<div class="form-group col-sm-6">
										<label>email: </label>
										<input class="form-control" type="text" value="{{$users['email']}}" name="email"  />
									</div>
									<div class="form-group col-sm-6">
										<label>Phone: </label>
										<input class="form-control" type="text" value="{{$user_other['mobile_no']}}" name="phone"  />
									</div>
									<div class="form-group col-sm-6">
										<label>Office: </label>
										<input class="form-control" type="text" value="{{$user_office['address_name']}}" name="office"  />
									</div>
							</div>
						<!-- <button type="submit" class="btn btn-success btn-sm">Upload</button> -->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success btn-sm">Update</button>
						</div>
						</form>
					</div>
				</div>
			</div>
			*/
			?>

			<!-- Edit Password -->
			<div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header bg-warning p-3">
						<h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Edit Password</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						</div>
						<div class="modal-body">
							<form id="update_user_password" method="post" action="{{route('user.update.profile.password')}}" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="form-group col-sm-12">
										<label>Old Password<span class="error">*</span> </label>
										<input type="password" class="form-control" name="old-password" minlength="8" required>
									</div>
									<div class="form-group col-sm-12">
										<label>New Password<span class="error">*</span> </label>
										<input type="password" class="form-control" name="password" minlength="8" required>
									</div>
									<div class="form-group col-sm-12">
										<label>Confirm Password<span class="error">*</span> </label><br>
										<input type="password" class="form-control" name="password_confirmation" minlength="8" required>
									</div>
									<!-- <div class="form-group col-sm-6">
									<label>Last Name:</label>
									<input type="text" name="promocode" class="form-control ">
									</div> -->
								</div>
								<!-- <button type="submit" class="btn btn-success btn-sm">Upload</button> -->

								<div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
									<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<!-- MODEL PART END -->
			<div class="page-main">
				<div class="page">
			<div class="page-main">

				<div class="app-content page-body">
					<div class="container">
												<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">{{ isset($userData->name) ? ucwords($userData->name) : '' }}</h4>
								<ol class="breadcrumb pl-0">
									<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
									<li class="breadcrumb-item"><a href="#">User</a></li>
								</ol>
							</div>
							<div class="page-rightheader">

							</div>
						</div>
						<!--End Page header-->

						@foreach ($errors->all() as $error)
						<div class="alert alert-danger">{{ $error }}</div>
						@endforeach

                        @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                        @endif

						@if (session('error'))
                        <div class="alert alert-danger">{{ session()->get('error') }}</div>
                        @endif

						<div class="row ">
							<div class="col-xl-3 col-lg-5 col-md-12 ">
								<div class="card  bg-azure-lightest ">
									<div class="card-body ">
										<div class="inner-all ">
											<ul class="list-unstyled ">
												<li class="text-center border-bottom-0 ">
													<?php
													if(isset($userOtherData->file_path) && $userOtherData->file_path != '')
													{
														?>
														<img data-no-retina="" class="img-circle img-responsive img-bordered-primary" src="{{ asset($userOtherData->file_path) }}"  alt="{{isset($userData->name) ? $userData->name : '' }}">
														<?php
													}
													else
													{
														?>
														<img data-no-retina="" class="img-circle img-responsive img-bordered-primary" src="{{ asset('storage/agas/box/dummy-user-img.png') }}"  alt="{{isset($userData->name) ? $userData->name : '' }}">
														<?php
													}
													?>
												</li>

												<li class="text-center">
													<h4 class="text-capitalize mt-3 mb-5">{{ isset($userData->name) ? ucwords($userData->name) : '' }}</h4>
												</li>
												<li>
													<a href="#" class="btn btn-primary text-center btn-block"><i class="fa fa-user" aria-hidden="true"></i> User-Account</a>
												</li>
												<li><br></li>
												<li>
													<div class="btn-group-vertical btn-block border-top-0">
														<a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#imageupload"><i class="fe fe-upload mr-2"></i>Upload</a>
														<br>
														<!--a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editaccount"></i>Edit Account</a-->
														<button type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false" class="btn btn-primary" data-toggle="modal" data-target="#updatePassword">
														<i class="fe fe-settings mr-2"></i> Edit Password
														</button>
														<!-- <a href="#" class="btn btn-outline-primary"><i class="fe fe-alert-circle mr-2"></i>Logout</a> -->
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- <div class="card panel-theme rounded shadow">
									<div class="card-header">
										<div class="float-left">
											<h3 class="card-title">Contact</h3>
										</div>
										<div class="card-options text-right">
											<a href="#" class="btn btn-sm btn-primary mr-2"><i class="fa fa-facebook"></i></a>
											<a href="#" class="btn btn-sm btn-primary mr-2"><i class="fa fa-twitter"></i></a>
											<a href="#" class="btn btn-sm btn-primary"><i class="fa fa-google-plus"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="card-body no-padding rounded">
										<ul class="list-group no-margin">
											<li class="list-group-item"><i class="fa fa-envelope mr-4"></i> johnsmith@gmail.com</li>
											<li class="list-group-item"><i class="fa fa-phone mr-4"></i> +125 5826 3658 </li>
										</ul>
									</div>
								</div> -->
							</div>
							<div class="col-xl-9 col-lg-7 col-md-12">
								<!-- /.profile-cover -->

								<div class="row">
									<div class="col-md-12">

										<div class="card">
											<div class="card-body">
												<div class=" " id="profile-log-switch">
													<div class="fade show active ">
														<div class="table-responsive border ">
															<table class="table row table-borderless w-100 m-0 ">
																<tbody class="col-lg-6 p-0">
																	<tr>
																		<td><strong>Full Name :</strong> {{ isset($userData->name) ? $userData->name : '' }}  </td>
																	</tr>
																	<tr>
																		<td><strong>Email :</strong> {{ isset($userData->email) ? $userData->email : '' }} </td>
																	</tr>
																	<tr>
																		<td><strong>Mobile :</strong> {{ isset($userOtherData->mobile_no) ? $userOtherData->mobile_no : '' }} </td>
																	</tr>
																	@if(isset($userData->display_name) && $userData->display_name != '')
																	<tr>
																		<td><strong>Role :</strong> {{ $userData->display_name }} </td>
																	</tr>
																	@endif
																</tbody>
																<tbody class="col-lg-6 p-0">
																	<?php
																	$gender = array();
																	$gender[''] = '';
																	$gender[1] = 'Male';
																	$gender[2] = 'Female';
																	$gender[3] = 'Other';
																	?>
																	<tr>
																		<td><strong>Gender :</strong> {{ isset($userOtherData->gender) ? $gender[$userOtherData->gender] : '' }}</td>
																	</tr>
																	<tr>
																		<td><strong>DOB :</strong> <?php echo date('d-m-Y',strtotime( isset($userOtherData->dob) ? $userOtherData->dob : '' )) ?></td>
																	</tr>
																	<tr>
																		<td><strong>Office : </strong> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }} </td>
																	</tr>
																</tbody>
															</table>
														</div>

													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header">
											<h3 class="card-title"><strong>User Log</strong></h3>
											</div>
											<div class="card-body">
												<div class="table-responsive">
													<table class="table table-striped table-bordered card-table table-vcenter">
													<thead class="text-white bg-azure-lightest">
													<tr>
													<th>User</th>
													<th>Change</th>
													<th>Time</th>
													</tr>
													</thead>
													<tbody>
														@foreach($user_log as $key=>$value)
														<tr>
														<td>{{$value['action_done_by_name']}}</td>
														<td>{{$value['action_name']}}</td>
														<td><?php echo date('d-m-Y H:i:s',strtotime($value['created_at'])); ?></td>
														</tr>
														@endforeach
													</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						</div>
				</div><!-- end app-content-->
				</div>
		</div>
	</div><!-- end app-content-->
	<script>
	$('#imageupload').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var recipient = button.data('whatever') // Extract info from data-* attributes
	})
	// edit account Model
	$('#editaccount').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var recipient = button.data('whatever') // Extract info from data-* attributes
	})
	//upload the USER image file
	$.ajaxSetup({
	headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});

	$('#uploadform').submit(function(e)
	{
		e.preventDefault();
		 // var formData = new FormData();
		 // alert(formData);
		 var custom_id = $('#user_id').val();
		 let formData = new FormData(this);
		 // console.log(formData);
		 $.ajax({
			 type:'POST',
			 url: '{{route("user.imageupload")}}',
			 data:formData,
			 contentType: false,
			 processData: false,
			 dataType: 'json',
			 success: function (data)
			 {
				 // alert(JSON.stringify(data));
					// $('#suseee').html(data
					if(data==1){
						window.location = '/users/'+custom_id;
				}

			 },
			 error: function(data)
			 {
				 console.log(data);
			 }
		 });
	});
	// edit account starts
	$('#editaccform').submit(function(e)
	{
		e.preventDefault();
		 // var formData = new FormData();
		 // alert(formData);
		 var custom_id = $('#user_id').val();
		 let formData = new FormData(this);
		 // console.log(formData);
		 $.ajax({
			 type:'POST',
			 url: '{{route("user.edit_account")}}',
			 data:formData,
			 contentType: false,
			 processData: false,
			 dataType: 'json',
			 success: function (data)
			 {
				 // alert(JSON.stringify(data));
					// $('#suseee').html(data
					if(data==1){
						window.location = '/users/'+custom_id;
				}

			 },
			 error: function(data)
			 {
				 console.log(data);
			 }
		 });
	});
	</script>
@endsection
