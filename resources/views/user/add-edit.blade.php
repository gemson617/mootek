@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Register</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('user.list')}}">Users</a></li>
                    <li class="breadcrumb-item"><a href="#">{{isset($add) ? 'Add' : (isset($edit) ? 'Edit' : 'View') }}</a></li>
                </ol>
            </div>
            <div class="page-rightheader">

                @if(isset($view))
                <button type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false" class="btn btn-sm bg-warning text-white font-weight-bold ml-1 float-right" data-toggle="modal" data-target="#updatePassword">
                    Update User Password <i class="fe fe-angle-down fe-sm fe-fw ml-0 text-white"></i>
                </button>
                @endif

            </div>
        </div>


        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach

        <!--End Page header-->
		@if(isset($view))
        <div class="card bg-azure-lightest">
            <div class="card-body"><div class="row">
                <div class="col-sm-2">
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
                </div>
                    <div class="col-sm-10">
                        <div class=" " id="profile-log-switch">
                            <div class="fade show active ">
                                <div class="table-responsive">
                                    <table class="table row w-100 m-0 table-borderless">
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <td><label>User Name :</label> {{ isset($userData->user_name) ? $userData->user_name : '' }} </td>
                                            </tr>
                                            <tr>
                                                <td><label>Full Name :</label> {{ isset($userData->name) ? $userData->name : '' }} {{ isset($userData->last_name) ? $userData->last_name : '' }} </td>
                                            </tr>
                                            <tr>
                                                <td><label>Email :</label> {{ isset($userData->email) ? $userData->email : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><label>Mobile :</label> {{ isset($userOtherData->mobile_no) ? $userOtherData->mobile_no : '' }}</td>
                                            </tr>
                                        </tbody>
                                        <tbody class="col-lg-6 p-0">
                                            <tr>
                                                <?php
                                                $gender = array();
                                                $gender[''] = '';
                                                $gender[1] = 'Male';
                                                $gender[2] = 'Female';
                                                $gender[3] = 'Other';
                                                ?>
                                                <td><label>Gender :</label> {{ isset($userOtherData->gender) ? $gender[$userOtherData->gender] : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><label>DOB :</label> {{ isset($userOtherData->dob) ? $userOtherData->dob : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td><label>Office : </label> {{ isset($userOtherData->address_name) ? $userOtherData->address_name : '' }}</td>
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
        @endif

        <div >


                @if(isset($edit) || isset($add))
                @if(isset($add))
                <form method="POST" action="{{ route('user.save') }}" enctype="multipart/form-data">
                @else
                <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                    <input type="hidden" id="user_id" name="user_id" value="{{ isset($id) ? $id : 0 }}">
                @endif
                @csrf
                @endif
                    <div class="row my-2">

                        <h5 class="col-sm-12 "><strong >Personal Details</strong></h5>
                        @if(isset($edit) || isset($add))
                            <div class="card p-2 mb-2 bg-azure-lightest">
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <label>First Name <span class="text-red">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($userData) ? $userData->name : old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <label>{{ $message }}</label>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Last Name <span class="text-red">*</span></label>
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ isset($userData) ? $userData->name : old('last_name') }}" required autocomplete="last_name" autofocus>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <label>{{ $message }}</label>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>UserName <span class="text-red">*</span></label>
                                        <input id="username" type="text" onchange="validateUsername(this.value);checkExists(this.value,'username1','user_name','UserName','username')" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ isset($userData) ? $userData->user_name : old('user_name') }}" required  autofocus>
                                        <span  class="username1"></span>
                                        <span  class="username2"></span>
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <label>{{ $message }}</label>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Email <span class="text-red">*</span></label>
                                        <input id="email" type="email" onchange="checkExists(this.value,'email1','email','Email','email')" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($userData) ? $userData->email : old('email') }}" required >
                                        <span  class="email1"></span>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <label>{{ $message }}</label>
                                            </span>
                                        @enderror
                                    </div>

                                    @if(!isset($userData))
                                        <div class="form-group col-sm-2">
                                            <label>{{ __('Password') }} <span class="text-red">*</span></label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <label>{{ $message }}</label>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-sm-2">
                                            <label>{{ __('Confirm Password') }} <span class="text-red">*</span></label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    @endif
                                @endif

                                <div class="form-group col-sm-2">
                                    <label>User Status <span class="text-red">*</span></label>
                                    <select id="status" name="status" class="form-control " required @if(isset($view)) disabled @endif>
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <label>{{ $message }}</label>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Tax File Number <span class="text-red">*</span></label>
                                    <input type="text" name="tax_file_no" class="form-control" value="{{ isset($userOtherData) ? $userOtherData->tax_file_no : old('tax_file_no') }}" required @if(isset($view)) disabled @endif>
                                </div>

                                @if(isset($edit) || isset($add))
                                    <div class="form-group col-sm-2">
                                        <label>DOB</label>
                                        <input id="dob" type="date" class="form-control click-date" name="dob" value="{{ isset($userOtherData) ? $userOtherData->dob : old('dob') }}" autocomplete="dob" @if(isset($view)) disabled @endif>
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Gender <span class="text-red">*</span></label>
                                        <select id="gender" name="gender" class="form-control " required @if(isset($view)) disabled @endif>
                                            <option value="">Select Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group col-sm-2">
                                    <label>Office</label>
                                    <select id="office_id" type="text" name="office_id" class="form-control " @if(isset($view)) disabled @endif>
                                        <option value="">Select office</option>
                                        @foreach($offices as $office)
                                        <option value="{{$office->id}}">{{$office->address_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Hourly Rate</label>
                                    <input type="text" name="hourly_rate" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->hourly_rate : old('hourly_rate') }}" @if(isset($view)) disabled @endif>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Building Name:</label>
                                    <input type="text" name="cbuild_name" id='cbuild_name' class="form-control"value="{{ isset($userData) ? $userData->build_name : old('build_name') }}" @if(isset($view)) disabled @endif>
                                </div>
                                <div class="form-group col-sm-2">
                                     <label>Building Type:</label>
                                    <select type="text" name="cbuild_type" id='cbuild_type' class="form-control"  @if(isset($view)) disabled @endif>
                                        @if(isset($add))<option value="">-Select Building Type-</option> @endif
                                        <?php foreach($building as $row){ ?>
                                            @if(isset($userData['build_type']) && $userData['build_type']==$row['id'])
                                            <option selected value="<?php echo $row['id']; ?>"><?php echo $row['building_types']; ?></option>
                                            @else
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['building_types']; ?></option>
                                            @endif

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Unit/Building No: </label>
                                    <input type="text" name="cbuild_no" id='cbuild_no'  class="form-control" value="{{ isset($userData) ? $userData->build_no : old('build_no') }}" @if(isset($view)) disabled @endif>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Street No:<span class="error">*</span></label>
                                    <input type="text" name="cstreet_no" id='cstreet_no' @if(isset($add)) required @endif class="form-control" value="{{ isset($userData) ? $userData->street_no : old('street_no') }}"  @if(isset($view)) disabled @endif>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Street Name:<span class="error">*</span></label>
                                    <input type="text" name="cstreet_name" onkeyup="searchStreetName(this.value,'cstreet_name','streetsearch',this,event)" id='cstreet_name' @if(isset($add)) required @endif class="form-control" value="{{ isset($userData) ? $userData->street_name : old('street_name') }}"  @if(isset($view)) disabled @endif>
                                    <div  id="streetsearch" data-subid="srch_subid" style = "width:100%; background-color:#fff; border:2px soild #000;">
                                    </div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Street Suffix:<span class="error">*</span></label>
                                    <select @if(isset($view)) disabled @endif type="text" name="cstreet_suffix" id='cstreet_suffix' class="form-control" value="{{ isset($userData) ? $userData->street_suffix : old('street_suffix') }}" @if(isset($add)) required @endif>
                                       @if(isset($add)) <option value="">-Select Street Suffix-</option> @endif
                                        <?php foreach($street as $row){ ?>
                                            @if(isset($userData['street_suffix']) && $userData['street_suffix']==$row['id'])
                                            <option selected value="<?php echo $row['id']; ?>"><?php echo $row['suffix']; ?></option>
                                            @else
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['suffix']; ?></option>
                                            @endif

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Suburb:<span class="error">*</span></label>
                                    <input @if(isset($view)) disabled @endif type="text" id = "srch_suburb" name="srch_suburb" onkeyup="postcodeSearch('srch_suburb','srch_post_code','postsearch',this,event);"  class="form-control " @if(isset($add)) required @endif value="{{ isset($userData) ? $userData->subrub_id : old('suburb_id') }}" >
                                    <div  id="postsearch" data-suburb="srch_suburb" data-postcode="srch_post_code" data-subid="srch_subid" data-state="srch_state" style = "width:100%; background-color:#fff; border:2px soild #000;">
                                    </div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Postcode<span class="error">*</span> </label>
                                    <input @if(isset($view)) disabled @endif type="text" id = "srch_post_code" name="srch_post_code"
                                        class="form-control " onkeyup="postcodeSearch('srch_suburb','srch_post_code','postsearch',this,event);" autocomplete="off" value="{{ isset($userData) ? $userData->postcode : old('postcode') }}" >
                                    <input type="hidden" id = "srch_subid" name="srch_subid"  class="form-control"    value="" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>State</label>
                                    <input type="text" name="srch_state" id="srch_state" class="form-control" value="{{ isset($userOtherData) ? $userOtherData->state : old('srch_state') }}" @if(isset($view)) disabled @endif>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Home Phone</label>
                                <input type="text" onkeypress="return isNumberKey(event)" id="home_phone" maxlength="8" name="home_phone_no"
                                    class="form-control " value="{{ isset($userOtherData) ? $userOtherData->mobile_no : old('home_phone_no') }}" @if(isset($view)) disabled @endif>
                                @error('home_phone_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                @if(isset($edit) || isset($add))
                                    <div class="form-group col-sm-2">

                                    <label>Mobile</label>
                                <input type="text" onkeypress="return isNumberKey(event)" id="mobile_pd" maxlength="10" name="mobile_no"
                                    class="form-control " value="{{ isset($userOtherData) ? $userOtherData->mobile_no : old('mobile_no') }}" @if(isset($view)) disabled @endif>
                                @error('pd_mobile')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                    </div>


                                @endif


                                </div>
                            </div>


                        @if(isset($edit) || isset($add))
                        <div class="form-group col-sm-6"></div>
                        @endif

                         <!--------------------------- detials of next of kin ---------------------------------->
                        <h5 class="col-sm-12 "><strong >Next of Kin</strong></h5>
                        <div class="card p-2 mb-2 bg-azure-lightest">
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <label>Name</label>
                                    <input type="text" name="next_of_kin" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->next_of_kin : old('next_of_kin') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Relationship</label>
                                    <input type="text" name="kin_relationship" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->kin_relationship : old('kin_relationship') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label>Address</label>
                                    <input type="text" name="kin_address" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->kin_address : old('kin_address') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Suburb:<span class="error">*</span></label>
                                    <input @if(isset($view)) disabled @endif type="text" id = "srch_suburb2" name="srch_suburb2" onkeyup="postcodeSearch('srch_suburb2','srch_post_code2','postsearch2',this,event);"  class="form-control srch_suburb2" @if(isset($add)) required @endif value="{{ isset($userData) ? $userData->kin_subrub_id : old('kin_suburb_id') }}" >
                                    <div  id="postsearch2" data-suburb="srch_suburb2" data-postcode="srch_post_code2" data-subid="srch_subid2" data-state="srch_state2" style = "width:100%; background-color:#fff; border:2px soild #000;">
                                    </div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Postcode:<span class="error">*</span></label>
                                    <input @if(isset($view)) disabled @endif type="text" id="srch_post_code2" name="srch_post_code2"
                                        class="form-control srch_post_code2" @if(isset($add)) required @endif onkeyup="postcodeSearch('srch_suburb2','srch_post_code2','postsearch2',this,event);" autocomplete="off" value="{{ isset($userData) ? $userData->kin_postcode : old('kin_postcode') }}" >
                                        <input type="hidden" id = "srch_subid2" name="srch_subid2"  class="form-control "  value="" >

                                </div>
                                <div class="form-group col-sm-2">
                                    <label>State</label>
                                    <input type="text" id="srch_state2" name="srch_state2" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->kin_state : old('kin_state') }}" @if(isset($view)) disabled @endif>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label>Home Phone</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" id="kin_home_phone" maxlength="8" name="kin_phone_no"
                                    class="form-control " value="{{ isset($userOtherData) ? $userOtherData->kin_phone_no : old('kin_phone_no') }}" @if(isset($view)) disabled @endif>
                                @error('kin_phone_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Mobile</label>
                                    <input type="text" onkeypress="return isNumberKey(event)" id="mobile_kin" maxlength="10" name="kin_mobile_no"
                                        class="form-control " value="{{ isset($userOtherData) ? $userOtherData->kin_mobile_no : old('kin_mobile_no') }}" @if(isset($view)) disabled @endif>
                                    @error('kin_mobile_no')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h5 class="col-sm-12 "><strong >Position Details</strong></h5>
                        <div class="card p-2 mb-2 bg-azure-lightest">
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <label>Role <span class="text-red">*</span></label>
                                    <select id="role_id" type="text" name="role_id" class="form-control" @if(isset($add)) required @endif @if(isset($view)) disabled @endif>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->display_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <label>{{ $message }}</label>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Employment Status</label>
                                    <select id="employment_status" type="text" name="employment_status" class="form-control " @if(isset($view)) disabled @endif>
                                        <option value="">Select Employment Status</option>
                                        <option value="1">Full Time</option>
                                        <option value="2">Part Time</option>
                                        <option value="3">Temporary</option>
                                        <option value="4">Casual</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Hours per week</label>
                                    <input type="text" name="hours" value="{{ isset($userOtherData) ? $userOtherData->mobile_no : old('mobile_no') }}" class="form-control " @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Joining Date</label>
                                    <input id="start_date" type="date" class="form-control click-date" name="start_date" value="{{ isset($userOtherData) ? $userOtherData->start_date : old('start_date') }}" autocomplete="start_date" @if(isset($view)) disabled @endif>
                                </div>
                                @isset($edit)
                                <div class="form-group col-sm-2">
                                    <label>Cease Employment Date</label>
                                    <input id="cease_date" type="date" class="form-control click-date" name="cease_date" value="{{ isset($userOtherData) ? $userOtherData->cease_date : old('cease_date') }}" autocomplete="cease_date" @if(isset($view)) disabled @endif>
                                </div>
                                @endisset
                            </div>
                        </div>



                        <h5 class="col-sm-12 "><strong >Banking And Superannuation Details</strong></h5>
                        <div class="card p-2 mb-2 bg-azure-lightest">
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <label>Bank</label>
                                    <input type="text" name="bank_name" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->bank_name : old('bank_name') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Branch</label>
                                    <input type="text" name="bank_branch" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->bank_branch : old('bank_branch') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Account Name</label>
                                    <input type="text" name="bank_account_name" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->bank_account_name : old('bank_account_name') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>BSB</label>
                                    <input type="text" name="bs_bno" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->bs_bno : old('bs_bno') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Bank Account Number</label>
                                    <input type="text" name="bank_account_no" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->bank_account_no : old('bank_account_no') }}" @if(isset($view)) disabled @endif>
                                </div>


                                <div class="form-group col-sm-2">
                                    <label>Superannuation Fund</label>
                                    <input type="text" name="superannuation_fund" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->superannuation_fund : old('superannuation_fund') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Member Number</label>
                                    <input type="text" name="superannuation_member_no" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->superannuation_member_no : old('superannuation_member_no') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>USI Number</label>
                                    <input type="text" name="superannuation_usi_no" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->superannuation_usi_no : old('superannuation_usi_no') }}" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Account Number</label>
                                    <input type="text" name="superannuation_account_no" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->superannuation_account_no : old('superannuation_account_no') }}" @if(isset($view)) disabled @endif>
                                </div>
                            </div>
                        </div>

                        <h5 class="col-sm-12 "><strong >Residency Details</strong></h5>
                        <div class="card p-2 mb-2 bg-azure-lightest">
                            <div class="row">
                                <div class="form-group col-sm-2">
                                    <label>Are you an Australian Citizen?</label>
                                    <select id="australian_citizen" type="text" name="australian_citizen" class="form-control " @if(isset($view)) disabled @endif>
                                       <option value="">Select </option>
                                       <option value="0">No</option>
                                       <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>If no, are you a permanent resident?</label>
                                    <select id="permanent_resident" type="text" name="permanent_resident" class="form-control " @if(isset($view)) disabled @endif>
                                        <option value="">Select </option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>If no, do you have a Working Visa?</label>
                                    <select id="working_visa" type="text" name="working_visa" class="form-control " @if(isset($view)) disabled @endif>
                                        <option value="">Select </option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>If yes, expiry date</label>
                                    <input id="visa_expiry_date" type="date" class="form-control click-date" name="visa_expiry_date" value="{{ isset($userOtherData) ? $userOtherData->visa_expiry_date : old('visa_expiry_date') }}" autocomplete="visa_expiry_date" @if(isset($view)) disabled @endif>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label>Any restrictions on your Working Visa?</label>
                                    <input type="text" name="visa_restrictions" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->visa_restrictions : old('visa_restrictions') }}" @if(isset($view)) disabled @endif>
                                </div>
                            </div>
                        </div>
                        <h5 class="col-sm-12 "><strong >User Qualifications</strong></h5>
                        <div class="card p-2 mb-2 bg-azure-lightest">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="col-sm-12 "><strong >Licenses</strong></h5>
                                    <div class="row" style="width:100%;">
                                        <div class="form-group col-4">
                                            <label>License provided Jurisdiction</label>
                                            <select id="license_det" type="text" name="license_det" class="form-control " @if(isset($view)) disabled @endif @if(isset($add)) required @endif>
                                               <option value="">Select </option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="Australian Capital Territory" )
                                                selected @endif
                                               value="Australian Capital Territory">Australian Capital Territory</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="New South Wales" )
                                               selected @endif  value="New South Wales">New South Wales</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="Northern Territory" )
                                               selected @endif  value="Northern Territory">Northern Territory</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="Queensland" )
                                               selected @endif  value="Queensland">Queensland</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="South Australia" )
                                               selected @endif  value="South Australia">South Australia</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="Tasmania" )
                                               selected @endif  value="Tasmania">Tasmania</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="Victoria" )
                                               selected @endif  value="Victoria">Victoria</option>
                                               <option @if(isset($userData['license_det']) && $userData['license_det']=="Western Australia" )
                                               selected @endif  value="Western Australia">Western Australia</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-4">
                                            <label>License Class</label>
                                            <select id="license_type" type="text" name="license_type" class="form-control " @if(isset($view)) disabled @endif @if(isset($add)) required @endif>
                                                <option value="">Select </option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="C Class" )
                                                selected @endif value="C Class">C Class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="LR class" )
                                                selected @endif value="LR class">LR class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="MR class" )
                                                selected @endif value="MR class">MR class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="HR class" )
                                                selected @endif value="HR class">HR class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="HC class" )
                                                selected @endif value="HC class">HC class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="MC class" )
                                                selected @endif value="MC class">MC Class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="RE Class" )
                                                selected @endif value="RE Class">RE Class</option>
                                                <option @if(isset($userData['license_type']) && $userData['license_type']=="R Class" )
                                                selected @endif value="R Class">R Class</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-4">
                                            <label>License Number</label>
                                            <input type="text" name="license_no" class="form-control " value="{{ isset($userData) ? $userData->license_no : old('license_no') }}" @if(isset($view)) disabled @endif @if(isset($add)) required @endif>
                                        </div>

                                        <div class="form-group col-4">
                                            <label>Expiry date</label>
                                            <input @if(isset($add)) required @endif id="license_expiry_date" type="date" class="form-control click-date" name="license_expiry_date" value="{{ isset($userData) ? $userData->license_expiry_date : old('license_expiry_date') }}" autocomplete="license_expiry_date" @if(isset($view)) disabled @endif>
                                        </div>
                                        <div class="form-group col-4">
                                            <label>Dangerous Goods License Number</label>
                                            <input type="text" name="dglicense_no" class="form-control " value="{{ isset($userData) ? $userData->dglicense_no : old('dglicense_no') }}" @if(isset($view)) disabled @endif @if(isset($add)) required @endif>
                                        </div>

                                        <div class="form-group col-4">
                                            <label>DGL Expiry date</label>
                                            <input @if(isset($add)) required @endif id="dglicense_expiry_date" type="date" class="form-control click-date" name="dglicense_expiry_date" value="{{ isset($userData->dglicense_expiry_date) ? $userData->dglicense_expiry_date : old('dglicense_expiry_date') }}" autocomplete="dglicense_expiry_date" @if(isset($view)) disabled @endif>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Upload License Copy</label>
                                            <input @if(isset($add)) required @endif type="file" name="license_file" class="form-control " value="{{ isset($userData) ? $userData->license_file_name : old('license_file_name') }}" @if(isset($view)) disabled @endif>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Upload Dangerous Goods License Copy</label>
                                            <input @if(isset($add)) required @endif type="file" name="dglicense_file" class="form-control " value="{{ isset($userData) ? $userData->license_file_name : old('license_file_name') }}" @if(isset($view)) disabled @endif>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Police criminal history check</label>
                                            <input @if(isset($add)) required @endif type="file" name="criminal_history" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->visa_restrictions : old('visa_restrictions') }}" @if(isset($view)) disabled @endif>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Police driving history report</label>
                                            <input @if(isset($add)) required @endif type="file" name="driving_history" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->visa_restrictions : old('visa_restrictions') }}" @if(isset($view)) disabled @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <table style="width:100%;">
                                        <tbody>
                                            <tr>
                                                <th>Do you have any Criminal History?</th>
                                                <td>

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="crimal_history" value="0" id="crimal_history" checked>
                                                        <label class="form-check-label" for="crimal_history">
                                                          No
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="crimal_history" value="1" id="crimal_history" >
                                                        <label class="form-check-label" for="crimal_history">
                                                          Yes
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>If yes, Upload document</label>
                                                        <input type="file" name="criminal_history_file" class="form-control " value="" @if(isset($view)) disabled @endif>
                                                        <label>Remarks</label>
                                                        <input type="text" name="criminal_remarks" class="form-control " value="{{ isset($userData) ? $userData->criminal_remarks : old('criminal_remarks') }}" @if(isset($view)) disabled @endif>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Do you have any pre-existing injuries?</th>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="injuries" value="0"  id="injuries" checked>
                                                        <label class="form-check-label" for="injuries">
                                                          No
                                                        </label>
                                                      </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="injuries" value="1"  id="injuries">
                                                        <label class="form-check-label" for="injuries">
                                                          Yes
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>If yes, Upload document</label>
                                                        <input type="file" name="injuries_file" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->visa_restrictions : old('visa_restrictions') }}" @if(isset($view)) disabled @endif>
                                                        <label>Remarks</label>
                                                        <input type="text" name="injuries_remarks" class="form-control " value="{{ isset($userData) ? $userData->injuries_remarks : old('injuries_remarks') }}" @if(isset($view)) disabled @endif>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Do you have any pre-existing health conditions?</th>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="health_condition"  value="0" id="health_condition" checked>
                                                        <label class="form-check-label" for="health_condition">
                                                         No
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="health_condition"  value="1" id="health_condition">
                                                        <label class="form-check-label" for="health_condition">
                                                         Yes
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>If yes, Upload document</label>
                                                        <input type="file" name="health_file" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->visa_restrictions : old('visa_restrictions') }}" @if(isset($view)) disabled @endif>
                                                        <label>Remarks</label>
                                                        <input type="text" name="health_remarks" class="form-control " value="{{ isset($userData) ? $userData->health_remarks : old('health_remarks') }}" @if(isset($view)) disabled @endif>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Do you have any vision condition?</th>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="vision_condition" value="0" id="vision_condition" checked>
                                                        <label class="form-check-label" for="vision_condition">
                                                          No
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="vision_condition" value="1" id="vision_condition">
                                                        <label class="form-check-label" for="vision_condition">
                                                          Yes
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>If yes, Upload document</label>
                                                        <input type="file" name="vision_file" class="form-control " value="{{ isset($userOtherData) ? $userOtherData->visa_restrictions : old('visa_restrictions') }}" @if(isset($view)) disabled @endif>
                                                        <label>Remarks</label>
                                                        <input type="text" name="vision_remarks" class="form-control " value="{{ isset($userData) ? $userData->criminal_remarks : old('vision_remarks') }}" @if(isset($view)) disabled @endif>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if(isset($edit) || isset($add))

                            <div style="margin-left: 1300px;" class="form-group col-sm-2 float-right">
                                <label class="w-100">&nbsp;</label>
                                <button type="submit" class="btn btn-sm btn-primary float-right">Submit</button>
                            </div>

                        @endif
                    </div>
                    @if(isset($edit) || isset($add))
                </form>
                @endif

        </div>
    </div>
</div>

@if(isset($view))
    <!-- Update user password modal -->
    <div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning p-3">
                <h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Update User Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <form id="update_user_password" method="post" action="{{route('user.update.password')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ isset($id) ? $id : 0}}" />
                        <div class="row">
                            <!--div class="form-group col-sm-12">
                                <label>Old Password: </label>
                                <input class="form-control" name="old-password">
                            </div-->
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
@endif

<script>
<?php
if(isset($edit) || isset($view))
{
    ?>
    jQuery('#status').val('<?php echo $userData->status;?>');
    <?php
    if($userOtherData)
    {
        ?>
        jQuery('#gender').val('<?php echo $userOtherData->gender;?>');
        jQuery('#office_id').val('<?php echo $userOtherData->office_id;?>');
        jQuery('#role_id').val('<?php echo $userData->role_id;?>');
        jQuery('#subrub_id').val('<?php echo $userOtherData->subrub_id;?>');
        jQuery('#kin_subrub_id').val('<?php echo $userOtherData->kin_subrub_id;?>');
        jQuery('#employment_status').val('<?php echo $userOtherData->employment_status;?>');
        jQuery('#australian_citizen').val('<?php echo $userOtherData->australian_citizen;?>');
        jQuery('#permanent_resident').val('<?php echo $userOtherData->permanent_resident;?>');
        jQuery('#working_visa').val('<?php echo $userOtherData->working_visa;?>');

        <?php
    }
}
?>
function get_suburb(val,post,sb){
    $('#'+post).val('');
    if(val.length > 0){
        var sub=$('#'+sb+' option:selected').text().split(" ");
        (sub[2]==null || sub[2]=='' ) ? $('#'+post).val(sub[1]):$('#'+post).val(sub[2]);
    }

}
function validateUsername(value){

if (/^[a-zA-Z0-9]+[_@-]+[a-zA-Z0-9]*$/.test(value))
{

    return (true);

}
                $('.username1').text("Invalid username ");
                $('.username1').show();
                $('.username1').addClass('text-danger');
                $('#username').val('');
  return (false)

}
function checkExists(val,error_cls,column,label,id){
var userId=$('#user_id').val();
//alert(val);
$.ajax({
            type: "GET",
            url: '{{route("user.check-exist")}}',
            data: {'column':column,'field': val},
            success: function(data) {
                //alert(data);
               if(data==='0'){
                $('.'+error_cls).hide();
                $('.'+error_cls).removeClass('text-info');
               }else{
                $('.'+error_cls).text("This "+label+" Already Exist, Add New "+label);
                $('.'+error_cls).show();
                $('.'+error_cls).addClass('text-danger');
                $('#'+id+'').val('');
               }
            }
    });
}
function mobile(value) {
        var x;
        x=value;
        document.getElementById('mobile_pd').value=x;
        document.getElementById('home_phone').value=x;
        document.getElementById('post_code').value=x;
        document.getElementById('kin_mobile_no').value=x;
        document.getElementById('kin_post_code').value=x;
        document.getElementById('kin_home_phone').value=x;
    }
    function postcodeSearch(suburb,post_code,div,ob,e) {
    if(e.keyCode != 9 && e.keyCode != 16)
    {
        if( $(ob).val().length < 3)
        {
            return;
        }
        postcode_val = $('#'+post_code).val();
        suburb_val =  $('#'+suburb).val();
        $.ajax({
                type: "GET",
                url: '{{route("customer.customer-loadpostcode")}}',
                data: {'srch_post_code': postcode_val, 'srch_suburb': suburb_val},
                success: function(data) {
                    $('#'+div).html('');
                    //alert(data);
                    if(data){
                        $('#'+div).html(data);
                        $('#'+div).show();
                }
            }
        });
    }
  }
  function  setPostCode(id,post_code,name,state,e) {
        $('#'+jQuery(e).parent().attr('data-suburb')).val(name);
        $('#'+jQuery(e).parent().attr('data-postcode')).val(post_code);
        $(e).parent().hide();
        $('#'+jQuery(e).parent().attr('data-subid')).val(id);
        $('#'+jQuery(e).parent().attr('data-state')).val(state);
}

</script>
@endsection
