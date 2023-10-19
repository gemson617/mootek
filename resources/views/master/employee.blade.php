@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">Add Employee</h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            @php
                            $decodedData = json_decode($cus_draft);
                            $json = $decodedData && isset($decodedData->data) ? json_decode($decodedData->data) : '';
                        @endphp
         
                            <form id="form" method="post" action="{{route('employee.emp_store')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">

                                    <div class="col-md-4">
                                        <label for="">First Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='first_name' value="<?=isset($json->first_name)?$json->first_name:'';  ?>" style="text-transform:uppercase" class="form-control @error('first_name') is-invalid @enderror data-input" name="first_name" placeholder=" First Name " />
                                            @error('first_name')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Last Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='last_name' style="text-transform:uppercase"   value="<?=isset($json->last_name)?$json->last_name:'';  ?>" class="form-control @error('last_name') is-invalid @enderror data-input" name="last_name" placeholder="Last Name " />
                                            @error('last_name')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">EmployeeID<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="number" id='employeeID' value="<?=isset($json->employeeID)?$json->employeeID:'';  ?>" class="form-control   @error('employeeID') is-invalid @enderror data-input" name="employeeID" placeholder="Employee ID" />
                                            @error('employeeID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <label for="">Password<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="password" id='password' class="form-control   @error('password') is-invalid @enderror data-input" name="password" placeholder="Enter Password" />
                                            @error('password')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-md-4">
                                        <label for="">Confirm Password<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="password" id='confirm_password' class="form-control   @error('confirm_password') is-invalid @enderror data-input" placeholder="Enter Confirm Password" name="confirm_password" />
                                            @error('password')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <label for="">Select Gender<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select  id='gender' class="form-select txt-num  @error('gender') is-invalid @enderror data-input" value="" name="gender" >
                                                <option value="">--select--</option>
                                                <option value="1"  <?=isset($json->gender)?($json->gender=='1'?'selected':''):'';  ?> >Male</option>
                                                <option value="2"  <?=isset($json->gender)?($json->gender=='2'?'selected':''):'';  ?> >Female</option>
                                        </select>
                                            @error('gender')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Select Blood Group<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select  id='blood_group' class="form-select txt-num  @error('blood_group') is-invalid @enderror data-input" value="" name="blood_group" >
                                                <option value="">--select--</option>
                                                <option value="A" <?=isset($json->blood_group)?($json->blood_group=='A'?'selected':''):'';  ?>>A</option>
                                                <option value="A+" <?=isset($json->blood_group)?($json->blood_group =='A+'?'selected':''):'';  ?>>A+</option>
                                                <option value="B" <?=isset($json->blood_group)?($json->blood_group =='B'?'selected':''):'';  ?>>B</option>
                                                <option value="B+" <?=isset($json->blood_group)?($json->blood_group =='B+'?'selected':''):'';  ?>>B+</option>
                                                <option value="O" <?=isset($json->blood_group)?($json->blood_group=='O'?'selected':''):'';  ?>>O</option>
                                                <option value="O+" <?=isset($json->blood_group)?($json->blood_group=='O+'?'selected':''):'';  ?>>O+</option>
                                                <option value="AB" <?=isset($json->blood_group)?($json->blood_group =='AB+'?'selected':''):'';  ?>>AB</option>
                                                <option value="AB+" <?=isset($json->blood_group)?($json->blood_group =='AB+'?'selected':''):'';  ?>>AB+</option>
                                        </select>
                                            @error('blood_group')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">DOB<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="date" id='dob' class="form-control  @error('dob') is-invalid @enderror data-input" name="dob"  value="<?=isset($json->dob)?$json->dob:'';  ?>" placeholder="Date Of Birth" />
                                            @error('dob')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Select Employee Role<span class="error">*</span><a class="fa fa-plus-circle" href="/role_master"></a></label>

                                        <div class="form-group">
                                            <select  id='role' class="form-select txt-num  @error('role') is-invalid @enderror data-input"  name="role" >
                                                <option value="">--select--</option>
                                                @foreach ($role as $val)
                                                <option value="{{$val->id}}" <?=isset($json->role)?($json->role==$val->id?'selected':''):'';  ?>>{{$val->role_name}}</option>
                                                @endforeach
                                        </select>
                                            @error('role')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Select Branch<span class="error">*</span><a class="fa fa-plus-circle" href="/company_master"></a></label>

                                        <div class="form-group">
                                            <select  id='branch' class="form-select txt-num  @error('branch') is-invalid @enderror data-input" name="branch" >
                                                <option value="">--select--</option>
                                                @foreach ($branch as $val)
                                                <option value="{{$val->id}}"  <?=isset($json->branch)?($json->branch==$val->id?'selected':''):'';  ?>>{{$val->company}}</option>
                                                @endforeach
                                        </select>
                                            @error('branch')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Office Email<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='office_email' value="<?=isset($json->office_email)?$json->office_email:'';  ?>" class="form-control  @error('office_email') is-invalid @enderror data-input" name="office_email" placeholder="Office Email" />
                                            @error('office_email')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Office Number<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='office_number'  value="<?=isset($json->office_number)?$json->office_number:'';  ?>" class="form-control   @error('office_number') is-invalid @enderror data-input" name="office_number" placeholder="Office Number" />
                                            @error('office_number')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Employee Address<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='employee_address' value="<?=isset($json->employee_address)?$json->employee_address:'';  ?>" class="form-control  @error('employee_address') is-invalid @enderror data-input" name="employee_address" placeholder="Employee Address" />
                                            @error('employee_address')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Branch State<span class="error">*</span> <a class="fa fa-plus-circle" href="/state"></a></label>
                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('state') is-invalid @enderror data-input state" onchange="get_city(this.value,'','city');" id='state' name="state">
                                                <option value="">--Select--</option>
                                                @foreach($states as $val)
                                                <option value="{{$val->id}}"  <?=isset($json->state)?($json->state==$val->id?'selected':''):'';  ?>>{{$val->state_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Branch City<span class="error">*</span> <a class="fa fa-plus-circle" href="/city"></a></label>

                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('city') is-invalid @enderror data-input city" id='city' name="city">
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        @error('city')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Pin Code<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='pin_code' value="<?=isset($json->pin_code)?$json->pin_code:'';  ?>"  class="form-control  @error('pin_code') is-invalid @enderror data-input" name="pin_code" placeholder="Pin Code" />
                                            @error('pin_code')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Emergency Contact<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='emergency_contact' value="<?=isset($json->emergency_contact)?$json->emergency_contact:'';  ?>" class="form-control  @error('emergency_contact') is-invalid @enderror data-input" name="emergency_contact" placeholder="Emergency Contact" />
                                            @error('emergency_contact')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Medical Policy ID No<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='medical_policyID'  value="<?=isset($json->medical_policyID)?$json->medical_policyID:'';  ?>" class="form-control  @error('medical_policyID') is-invalid @enderror data-input" name="medical_policyID" placeholder="Medical Policy ID" />
                                            @error('medical_policyID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Monthly salary<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='monthly_salary' value="<?=isset($json->monthly_salary)?$json->monthly_salary:'';  ?>" class="form-control  @error('monthly_salary') is-invalid @enderror data-input" name="monthly_salary" placeholder="Monthly Salary" />
                                            @error('monthly_salary')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Last Increment Date</label>
                                        <div class="form-group">
                                            <input type="date" id='last_increament_date' value="<?=isset($json->last_increament_date)?$json->last_increament_date:'';  ?>" class="form-control  @error('last_increament_date') is-invalid @enderror data-input" value="<?php echo date('Y-m-d');?>" placeholder="last_increament_date" name="last_increament_date" />
                                            @error('last_increament_date')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Photo<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='photo'  class="form-control  @error('photo') is-invalid @enderror data-input" placeholder="photo" name="photo" />
                                          <a href="" id='photo_image' class='pdf_file d-none'><i class="fa fa-download"></i></a>  

                                          {{-- <img src="" alt="" style="width: 50%;height: 104px;display:none" > --}}
                                            @error('photo')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">ID Proof<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='ID_proofs' class="form-control  @error('ID_proofs') is-invalid @enderror data-input" placeholder="ID_proofs" name="ID_proofs" />
                                            <a href="" id='ID_proofs_image' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                            @error('ID_proofs')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Resume<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='resume' class="form-control  @error('resume') is-invalid @enderror data-input" placeholder="resume" name="resume" />
                                            <a href="" id='resume_image' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                            @error('resume')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">PAN Card<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='pan_card' class="form-control  @error('pan_card') is-invalid @enderror data-input" placeholder="pan_card" name="pan_card" />
                                            <a href="" id='pan_card_iamge' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                            @error('pan_card')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Aadhar Card<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='aadhar_proof_path' class="form-control  @error('aadhar_proof_path') is-invalid @enderror data-input" placeholder="aadhar_proof_path" name="aadhar_proof_path" />
                                            <a href="" id='aadhar_proof_path_image' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                         
                                            @error('aadhar_proof_path')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Degree Certificates<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='degree_certificates' class="form-control  @error('degree_certificates') is-invalid @enderror data-input" placeholder="degree_certificates" name="degree_certificates" />
                                            <a href="" id='degree_certificates_image' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                            @error('degree_certificates')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Mark Sheet+Additional<span class="error">*</span> </label>
                                        <div class="form-group">
                                            <input type="file" id='mark_sheet' class="form-control  @error('mark_sheet') is-invalid @enderror data-input" placeholder="mark_sheet" name="mark_sheet" />
                                            <a href="" id='mark_sheet_image' class='pdf_file d-none'><i class="fa fa-download"></i></a>
                                            @error('mark_sheet')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="">Select Status</label>
                                        <div class="form-group">

                                            <select class="form-select txt-num  @error('status') is-invalid @enderror data-input status" id='status' name="status">
                                                <option value="">--Select--</option>
                                                <option value="1" <?=isset($json->status)?($json->status==1?'selected':''):'';  ?>>Active</option>
                                                <option value="0" <?=isset($json->status)?($json->status==0?'selected':''):'';  ?>>In Active</option>
                                            </select>
                                            @error('status')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    
                                </div>
                             
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                        <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>



           <div class="row pb-5">

                <table id="datatable" class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Employee First Name</th>
                            <th>Employee Last Name</th>
                            <th>Employee ID</th>
                            <th>Office Number</th>
                            <th>Office Email</th>
                            <th>Employee Role</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $val)
                        <tr>
                            <td>{{$val->first_name}}</td>
                            <td>{{$val->last_name}}</td>
                            <td>{{$val->employeeID}}</td>
                            <td>{{$val->office_number}}</td>
                            <td>{{$val->office_email}}</td>
                            <td>{{$val->role}}</td>
                            <td>{{$val->gender}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               


                            <td><a href="javascript:void(0)" data="<?= $val->id ?>" class="btn btn-primary edit_form "><i class="fa fa-edit"></i></a>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="User" class='btn btn-info change'>status</button>
                                {{-- <button class="btn btn-info change" data="{{$val->status}}" data-id="{{$val->id}}">Change Status</button> --}}

                            </td>
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
<script>
 $(document).ready(function () {
            // Initialize Select2 for select elements with the 'select2-input' class
            $('.select2-input').select2();

            $('.data-input').on('input change', handleInputChange);

            function handleInputChange() {
                var jsonData = {};

                $('.data-input').each(function () {
                    jsonData[$(this).attr('name')] = $(this).val();
                });

                // Send JSON data to the server using an AJAX request
                $.ajax({
                    url: '/emp-draft',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(jsonData),
                    contentType: 'application/json',
                    success: function (data) {
                        // Handle the response here, e.g., show a success message
                        console.log(data.message);
                    },
                    error: function (error) {
                        // Handle any errors, e.g., display an error message
                        console.error(error);
                    }
                });
            }
        });

            $('#datatable tbody').on('click', '.edit_form', function() {
            id = $(this).attr('data');
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('employee.emp_index')}}",
                success: function(data) {
                    // console.log(data);
                  
                    $(".pdf_file").click(function(event) {
                        event.preventDefault(); // Prevent the default link behavior (i.e., opening the URL in the current tab)
                        var url = $(this).attr('href'); // Get the URL from the link
                        window.open(url, '_blank'); // Open the URL in a new tab
                    });

                    $(".pdf_file").removeClass('d-none');
                    $("#first_name").val(data.data.first_name);
                    $("#last_name").val(data.data.last_name);
                    $("#employeeID").val(data.data.employeeID);
                    $("#gender").val(data.data.gender).select2();
                    $("#blood_group").val(data.data.blood_group).select2();
                    $("#role").val(data.data.role).select2();
                    $("#branch").val(data.data.branch).select2();
                    $("#state").val(data.data.state).select2();
                    $("#city").val(data.data.city).select2();
                    $("#dob").val(data.data.dob);
                    $("#office_email").val(data.data.office_email);
                    $("#office_number").val(data.data.office_number);
                    // $("#photo").val(data.data.photo);
                    // $("#secondary_contact").val(data.data.secondary_contact);
                    $("#employee_address").val(data.data.employee_address);
                    $("#dob").val(data.data.dob);
                    $("#pin_code").val(data.data.pin_code);
                    // $("#present_address").val(data.data.present_address);
                    $("#emergency_contact").val(data.data.emergency_contact);
                    $("#medical_policyID").val(data.data.medical_policyID);
                    $("#monthly_salary").val(data.data.monthly_salary);
                    $("#last_increament_date").val(data.data.last_increament_date);
                    $("#status").val(data.data.status).select2();
                    $("#photo_image").css('display','block');
                    $("#ID_proofs_image").css('display','block');
                    $("#resume_image").css('display','block');
                    $("#pan_card_image").css('display','block');
                    $("#degree_certificates_image").css('display','block');
                    $("#mark_sheet_image").css('display','block');
                    $("#aadhar_proof_image").css('display','block');
                    $("#photo").rules("remove");
                    $("#ID_proofs").rules("remove");
                    $("#resume").rules("remove");
                    $("#pan_card").rules("remove");
                    $("#degree_certificates").rules("remove");
                    $("#mark_sheet").rules("remove");
                    $("#aadhar_proof_path").rules("remove");
                    $("#photo_image").attr('href',data.data.photo);
                    $("#ID_proofs_image").attr('href',data.data.ID_proofs);
                    $("#resume_image").attr('href',data.data.resume);
                    $("#pan_card_image").attr('href',data.data.pan_card);
                    $("#degree_certificates_image").attr('href',data.data.degree_certificates);
                    $("#mark_sheet_image").attr('href',data.data.mark_sheet);
                    $("#aadhar_proof_image").attr('href',data.data.aadhar_proof_path);
                    $(".card-title").html('Edit Employee').css('color', 'red');
                    $("#id").val(data.data.id);
                    $("#name").focus();
                    scrollToTop();
                    $('#password').rules('remove','required');
                    $('#confirm_password').rules('remove','required');
                    $('#address_proof').rules('remove','required');

                }
            });



        });

        $('#datatable tbody').on('click', '.delete_modall', function() {
            id = $(this).val();
            $("#delete_id").val(id);
            $("#delete_modal").modal('show');
        });
        $("#delete").click(function() {

            id = $('#delete_id').val();
            $.ajax({
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,

                },
                url: "{{route('employee.emp_delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload();
                }
            });
        });
    $(document).ready(function() {


        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);




        // $('#datatable').DataTable({
        //     "ordering": false
        // });

    });


     // VALIDATION ON FORM SUBMIT
     $('form[id="form"]').validate({
        rules: {
            first_name: 'required',
            last_name: 'required',
            branch: 'required',
            employeeID: {
            required: true,
            number: true, // This rule ensures that the input is a valid number
            },
            email: {
            required: true,
            validEmail: true
            },
            office_email: {
                required: true,
                validEmail: true
                },
            office_number: {
            required: true,
            number: true, // This rule ensures that the input is a valid number
            pattern:/^[0-9]{10}$/
            },
            emergency_contact: {
            required: true,
            number: true, // This rule ensures that the input is a valid number
            pattern:/^[0-9]{10}$/
            },
            monthly_salary: {
            required: true,
            number: true, // This rule ensures that the input is a valid number
            },
            role: 'required',
            employee_address: 'required',
            state: 'required',
            city: 'required',
            pin_code: 'required',
            medical_policyID: 'required',
            dob: 'required',
            blood_group: 'required',
            gender:'required',
            status:'required',
         ID_proofs: {
          required: true,
          accept: "application/pdf, image/*"
        },
        photo: {
          required: true,
          extension: "jpg|jpeg|png"
        },
        resume: {
          required: true,
          accept: "application/pdf, image/*"
        },pan_card: {
          required: true,
          accept: "application/pdf, image/*"
        },
        aadhar_proof_path: {
          required: true,
          accept: "application/pdf, image/*"
        },
        degree_certificates: {
          required: true,
          accept: "application/pdf, image/*"
        },
        mark_sheet: {
          required: true,
          accept: "application/pdf, image/*"
        }

        },
        messages: {
            first_name: 'First Name is Required',
            last_name: 'Last Name is Required',
            branch: 'Branch is Required',
            employeeID: {
            required: 'EmployeeID is Required',
            number: 'Valid Number', // This rule ensures that the input is a valid number
            },
            email: {
            required:  'This  Email  is Required',
            },
            office_email: {
                required:  'This Office Email  is Required',
                email: 'Please enter a valid email address'
                },
            office_number: {
            required: 'This  Office No  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            pattern: "Please Enter 10 Digit Number"
            },
            office_number: {
            required: 'This  Office No  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            pattern: "Please Enter 10 Digit Number"
            },
            emergency_contact: {
            required: 'This  Emergency Contact  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            pattern: "Please Enter 10 Digit Number"
            },
            monthly_salary: {
            required: 'This  Monthly Salary  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            },
            role: 'Role is Required',
            employee_address: 'Employee Address is Required',
            state: 'State is Required',
            city: 'City is Required',
            pin_code: 'Pin Code is Required',
            medical_policyID: ' Medical Policy ID is Required',
            blood_group : 'Blood Group is Required',
            dob : 'Date of Birth is Required',
            gender:'Gender is Required',
            status:'Status is Required',
        ID_proofs: {
          required: "Please select an ID proof document.",
          accept: "Only PDF, JPG, JPEG, or PNG files are allowed."
        },
        photo: {
          required: "Photo is Required.",
          extension: "Only JPG, JPEG, or PNG files are allowed."
        },
        resume: {
          required: "Please select an Resume document.",
          accept: "Only PDF, JPG, JPEG, or PNG files are allowed."
        },
        pan_card: {
          required: "Please select an Pan Card  document.",
          accept: "Only PDF, JPG, JPEG, or PNG files are allowed."
        },
        aadhar_proof_path: {
          required: "Please select an  Aadhar Proof document.",
          accept: "Only PDF, JPG, JPEG, or PNG files are allowed."
        },
        degree_certificates: {
          required: "Please select an Degree Certificates  document.",
          accept: "Only PDF, JPG, JPEG, or PNG files are allowed."
        },
        mark_sheet: {
          required: "Please select an Mark Sheet document.",
          accept: "Only PDF, JPG, JPEG, or PNG files are allowed."
        }
        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
        if (element.hasClass('form-select') && element.next('.select2-container').length) {
            label.insertAfter(element.next('.select2-container'));
        } else {
            label.insertAfter(element);
        }
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
    $.validator.addMethod(
    "validEmail",
    function (value, element) {
      // Use a regular expression for email validation
      return /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(value);
    },
    "Please enter a valid email address"
  );
</script>
@endsection