@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        @if (session('msg'))
        <div class="alert alert-success" role="alert">
            {{ session('msg') }}
        </div>
        @endif
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">User Detail</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
                    <li class="breadcrumb-item"><a href="#">User Detail</a></li>
                </ol>
            </div>
            <div class="page-rightheader"></div>
        </div>
        <!--End Page header-->
    </div>
    <!-- Page Heading -->
    <div class="container">
        <div class="">
            <div class="col-12 card shadow mb-4 ">
                <div class="card-body p-3">
                    <div class="d-sm-flex align-items-center justify-content-between mb-0">
                        <h4 class="mb-0 text-gray-800">{{ $userData ? Ucfirst($userData->name) : '' }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-12  shadow mb-4 ">
                <div class="card bg-azure-lightest">
                    <div class="card-body"><div class="row">
                        <div class="col-sm-2" >
                            <?php
                            if(isset($userOtherData->file_path) && $userOtherData->file_path != '')
                            {
                                ?>
                                <img  data-no-retina="" class="img-circle img-responsive img-bordered-primary" src="{{ asset($userOtherData->file_path) }}"  alt="{{isset($userData->name) ? $userData->name : '' }}">
                                <?php
                            }
                            else
                            {
                                ?>
                                <img  data-no-retina="" class="img-circle img-responsive img-bordered-primary" src="{{ asset('storage/agas/box/dummy-user-img.png') }}"  alt="{{isset($userData->name) ? $userData->name : '' }}">
                                <?php
                            }
                            ?>
                            <br>
                            <a  href="#" class="btn btn-sm btn-outline-primary mt-3" data-toggle="modal" data-target="#imageupload"><i class="fe fe-upload mr-2"></i>Upload</a>
                        </div>
                            <div class="col-sm-10">
                                <div class=" " id="profile-log-switch">
                                    <div class="fade show active ">
                                        <div class="table-responsive">
                                            <table class="table row w-100 m-0 table-borderless">
                                                <tbody class="col-lg-4 p-0">
                                                    <tr>
                                                        <td><strong>User Name :</strong> {{ isset($userData->user_name) ? $userData->user_name : '' }}
                                                            (@if(isset($userData->status))
                                                            @if($userData->status == 1) Active @else Inactive @endif
                                                            @endif) </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Full Name :</strong> {{ isset($userData->name) ? $userData->name : '' }} {{ isset($userData->last_name) ? $userData->last_name : '' }} </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address :</strong> {{ isset($userOtherData->mobile_no) ? $userOtherData->mobile_no : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email :</strong> {{ isset($userData->email) ? $userData->email : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Mobile :</strong> {{ isset($userOtherData->mobile_no) ? $userOtherData->mobile_no : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Home Phone :</strong> {{ isset($userOtherData->mobile_no) ? $userOtherData->mobile_no : '' }}</td>
                                                    </tr>
                                                </tbody>
                                                <tbody class="col-lg-4 p-0">
                                                    <tr>
                                                        <?php
                                                        $gender = array();
                                                        $gender[''] = '';
                                                        $gender[1] = 'Male';
                                                        $gender[2] = 'Female';
                                                        $gender[3] = 'Other';
                                                        ?>
                                                        <td><strong>Gender :</strong> {{ isset($userOtherData->gender) ? $gender[$userOtherData->gender] : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>DOB :</strong> {{ isset($userOtherData->dob) ? $userOtherData->dob : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Office : </strong> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Tax File No : </strong> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }}</td>
                                                    </tr>
                                                </tbody>
                                                <tbody class="col-lg-4 p-0">
                                                    <tr>
                                                        <td></td>
                                                        <td><strong>Kin Details</strong> </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>

                                                        <td><strong>Name :</strong> {{ isset($userOtherData->gender) ? $gender[$userOtherData->gender] : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Relationship :</strong> {{ isset($userOtherData->dob) ? $userOtherData->dob : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address : </strong> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Mobile No : </strong> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Home Phone : </strong> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }}</td>
                                                    </tr>
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
            <div class="col-12  shadow mb-4 ">
                <div class="card bg-azure-lightest">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Position Details</div>
                                    </div>
                                    <div class="card-body">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Role</strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Employement Status</strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Hours per week</strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Joined Date</strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Australian Citizen</strong></td>
                                                    <td></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Bank Details</div>
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">User Qualifications</div>
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!----------------------------------------------------upload image start-------------------->
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
                        <input type="hidden" name="user_id" id="user_id" value="{{$id}}" />
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
    <!------------------------------------------------------upload image end-------------------->
</div>
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
			 url: '{{route("user.imageupload_user")}}',
			 data:formData,
			 contentType: false,
			 processData: false,
			 dataType: 'json',
			 success: function (data)
			 {
				 // alert(JSON.stringify(data));
					// $('#suseee').html(data
					if(data==1){
						window.location = '/view/user/'+custom_id;
				}

			 },
			 error: function(data)
			 {
				 console.log(data);
			 }
		 });
	});
	// edit account starts

	</script>
@endsection
