@extends('layouts.app')

@section('content')
<style>
    #password-error{
        position: absolute;
top: 37px;
    }
    #new_password-error{
        position: absolute;
        top: -28px;
    }
    #confirm_password-error{
        position: absolute;
        top: -28px;
    }
    #designation-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }

</style>
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">Add User</h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('user.add')}}">
                                @csrf
                                <input type="hidden" value="" name="role" id='role'>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">UserName<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="Text" id='username' class="form-control  @error('username') is-invalid @enderror" placeholder="Enter Username" value="{{old('username')}}" name="username" />
                                            @error('username')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Email <span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="email" id='email' class="form-control  @error('email') is-invalid @enderror" placeholder="Enter Email" value="{{old('email')}}" name="email" />
                                            @error('email')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">Password <span class="error">*</span></label>

                                        <div class="input-group">
                                            <input type="password" id='password' class="form-control  @error('password') is-invalid @enderror" placeholder="Enter Password" value="{{old('password')}}" name="password" />
                                        			 									<span class="input-group-text togglePassword " >
												 <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>
                                            @error('password')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Designation <span class="error">*</span></label>

                                        <div class="form-group">
                                            <select  id='designation' class="form-select txt-num  @error('designation') is-invalid @enderror" value="" name="designation" >
                                                <option value="">--select--</option>
                                                 @foreach ($designation as $val)
                                                <option value="{{$val->id}}">{{$val->designation_name}}</option>
                                                     
                                                 @endforeach
                                        </select>
                                            @error('designation')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-3 pb-2">
                                        <label for="">Role <span class="error">*</span></label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="3" name='role' id="flexCheckDefault" />
                                            <label class="form-check-label" for="flexCheckDefault">Super Admin</label>
                                        </div>

                                        <!-- Checked checkbox -->
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button class="btn btn-sm btn-success mr-1 checkmodel"> Save and Update</button>
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
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datatable as $val)
                        <tr>
                            <td>{{$val->user_name}}</td>
                            <td><?php echo $val->role_id == '1' ? 'Admin' : 'Super Admin'; ?></td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->designation_name}}</td>
                            <td><button class='btn btn-info change_passsword password_id' value='{{$val->id}}'>Change Password</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal change" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id='form_change' action="{{route('password.confirm')}}" method='post'>
                                @csrf
                                <input type="hidden" name='id' id='pass_id'>
                                <div class="row">
                                    <label for="">Password <span class="error">*</span></label>

                                    <div class="input-group">
                                        <input type="password" id='new_password' class="form-control  @error('new_password') is-invalid @enderror" placeholder="Enter Password" name="new_password" required />
                                        <span class="input-group-text  " onclick="myFunction('new_password')">
												 <i class="fa fa-eye-slash new_password" aria-hidden="true"></i>
                                                </span>
                                        @error('new_password')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="">Confirm Password <span class="error">*</span></label>

                                    <div class="input-group">
                                        <input type="password" id='confirm_password' class="form-control  @error('confirm_password') is-invalid @enderror" placeholder="Enter Confirm Password" value="{{old('confirm_password')}}" required name="confirm_password" />
                                        <span class="input-group-text  " onclick="myFunction('confirm_password')" >
												 <i class="fa fa-eye-slash confirm_password"  aria-hidden="true"></i>
                                                </span>
                                        @error('confirm_password')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- <div id='checkmodel' class="modal checkmodel1" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" id='delete_id' name='id'>
                        <div class="modal-body">
                            <p>Are you Super Admin?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" value='3' id='super_admin'>Yes,Super Admin</button>
                            <button type="button" class="btn btn-secondary" value='1' id='admin'>No,Admin</button>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
    </div>
</div>
</div>
</div>
</div>
<script>
    $(document).on('click', '.togglePassword', function() {
var input = $("#password");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
if(input.attr('type') === 'password'){
	$('.togglePassword>i').removeClass("fa fa-eye");
	$('.togglePassword>i').addClass("fa fa-eye-slash");

}else{
	$('.togglePassword>i').removeClass("fa fa-eye-slash");
	$('.togglePassword>i').addClass("fa fa-eye");

}
});
 function myFunction(id){
    var input = $("#"+id+"");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
if(input.attr('type') === 'password'){
	$("."+id+"").removeClass("fa fa-eye");
	$("."+id+"").addClass("fa fa-eye-slash");
}else{
	$("."+id+"").removeClass("fa fa-eye-slash");
	$("."+id+"").addClass("fa fa-eye");

}
}

    $('form[id="form"]').validate({
        ignore: 'input[type=hidden], .select2-input, .select2-focusser',
        rules: {
            username: 'required',
            email: 'required',
            password: 'required',
            reference: 'required',
            designation: {
                required: true
            },
            company: 'required',
        },
        messages: {
            username: 'This username is required',
            email: 'This email is required',
            password: 'This password is required',
            reference: 'This reference is required',
            designation: 'This designation is required',
            company: 'This company is required',
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

    $('form[id="form_change"]').validate({
        rules: {
            new_password: true,
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            new_password: 'This new_password is required',
            confirm_password: {
                required: 'This confirm_password is required',
            },
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

    $(document).ready(function() {

        // $('#datatable').DataTable({
        //     "ordering": false
        // });
        
        // // Password and confirm password field references
        // var passwordField = $('#new_password');
        // var confirmPasswordField = $('#confirm_password');
        // var passwordError = $('#password_error');

        // // Event handler for confirming password
        // confirmPasswordField.on('keyup', function() {

        //     var password = passwordField.val();
        //     var confirmPassword = confirmPasswordField.val();

        //     if (password === confirmPassword) {

        //         passwordError.hide();
        //     } else {
        //         passwordError.show();
        //     }
        // });

        $(".change_passsword").click(function() {
            var pass = $(this).val();
            $("#pass_id").val(pass);
            $(".change").modal('show');
        });

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);








    });
</script>
@endsection