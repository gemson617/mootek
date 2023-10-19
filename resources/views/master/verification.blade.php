@extends('layouts.app')






@section('content')
<header class="page-header">

</header>

<section class="page-content">

<div class="row">

    <div class="col-md-4">

        <div class="card">

            <h5 class="card-header">Pan Verification</h5>

            <form id='pan' method="post" action="{{route('verification')}}">
@csrf
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">

                            <label for="validationCustomUsername">Pan Number</label>

                            <input type="text" class="form-control txt-num  @error('pan') is-invalid @enderror" id='pan' name="pan" value="" required>
                                    @error('pan')
                                        <div class="error">*{{$message}}</div>
@enderror
                        </div>

                        

                    </div>

                </div>

                <div class="card-footer bg-light">

                    <div class="row">                                        

                        <div class="col-md-6">

                            <button class="btn btn-primary" type="submit" name="submitpan">Check Pan Details</button>

                        </div>

                        

                    </div>										

                </div>
          

            </form>

        </div>
        <?php  
  if($otp =='pan'){ 

    ?>
        <div class="alert alert-success" role="alert">
                            PAN No : <?php echo $pan.'<br>'; ?>
                            FULL NAME       :<?php echo $pan_name.'<br>'; ?>
                            
                         </div>

                         <?php }else if($otp =='pan_fail'){  ?>
                                                     <div class="alert alert-danger" role="alert">
                                                        Invalid
                                                     </div>
                    <?php     } ?>
    </div>

    <div class="col-md-4">

        <div class="card">

            <h5 class="card-header">Aadhar Verification</h5>
            <form id='aadhar' method="post" action="<?php echo $otp=='success'? "/verify_otp_aadhar": "/verify_aadhar"; ?>">
            @csrf
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">
                           
                            <label for="validationCustomUsername">Aadhar Number</label>

                            <input type="text" class="form-control txt-num  @error('adhar') is-invalid @enderror" value='<?php echo ($otp =='success')? $aadhar : ''; ?>' <?php echo ($otp =='success')? 'disabled' : ' '; ?> id='adhar' name="adhar" required>
                            @error('adhar')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                               
                            <?php 
                            if($otp =='success'){
                            ?>
                            <input type="hidden" name='adhar1' value='{{$client}}'>
                            <label for="validationCustomUsername">Enter OTP</label>
  
                            <input type="text" class="form-control txt-num  @error('otp') is-invalid @enderror" id='otp' name="otp" required>
                            @error('otp')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                               
                            <?php }
                            ?>
                           
                        </div>

               

                    </div>

                </div>

                <div class="card-footer bg-light">

                    <div class="row">

                        <div class="col-md-8">

                            <button class="btn btn-primary" type="submit" name="submitadhar">Check Aadhar Details</button>

                        </div>

                        

                    </div>										

                </div>
                 
            </form>
 
        </div>
        <?php  
  if($otp =='aadhar_success'){ 

    ?>
        <div class="alert alert-success" role="alert">
                            Aadhar no : <?php echo $aadhar.'<br>'; ?>
                            Name       :<?php echo $Name.'<br>'; ?>
                            DOB       :<?php echo $DOB.'<br>'; ?>
                            Gender       :<?php echo $Gender.'<br>'; ?>
                            
                         </div>

                         <?php }else if($otp =='aadhar_fail'){  ?>
                                                     <div class="alert alert-danger" role="alert">
                                                        Invalid
                                                     </div>
                    <?php     } ?>
    </div>

    <div class="col-md-4">

        <div class="card">

            <h5 class="card-header">Licence Verification</h5>

            <form id='licence' method="post" action="{{route('verify.licence')}}">
            @csrf

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">

                            <label for="validationCustomUsername">Licence Number</label>

                            <input type="text" class="form-control txt-num  @error('aadhar') is-invalid @enderror" id='aadhar' name="aadhar">
                            @error('aadhar')
                                <div class="error">*The licence number field is required.</div>
                            @enderror
                            <br/>
                            <label for="validationCustomUsername">Date of birth</label>
                            <input type="date" class="form-control txt-num  @error('dob') is-invalid @enderror" name="dob">
                            @error('dob')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                               

                        </div>

                        

                    </div>

                </div>
                <div class="card-footer bg-light">

                    <div class="row">

                        <div class="col-md-8">

                            <button class="btn btn-primary" type="submit" name="submitLicence">Check Licence Details</button>

                        </div>

                        

                    </div>										

                </div>

            </form>

        </div>
        <?php  
  if($otp =='licence_success'){ 

    ?>
        <div class="alert alert-success" role="alert">
                            Licence no : <?php echo $Name.'<br>'; ?>
                            Permanent Address       :<?php echo $PA.'<br>'; ?>
                            Temporary  Address      :<?php echo $TA.'<br>'; ?>
                            
                         </div>

                         <?php }else if($otp =='licence_fail'){  ?>
                                                     <div class="alert alert-danger" role="alert">
                                                        Invalid
                                                     </div>
                    <?php     } ?>
    </div>

</div>
</section>



<script>
  
    $('form[id="licence"]').validate({
              ignore: 'input[type=hidden], .select2-input, .select2-focusser',
              rules: {
                  aadhar: 'required',
                  dob: 'required',
              },
              messages: {
                  aadhar: 'This Licence Number is required',
                  dob: 'This DOB is required',
  
              },
              errorPlacement: function(label, element) {
                      label.addClass('mt-2 text-danger');
                  if(element.hasClass('form-select') && element.next('.select2-container').length) {
                  label.insertAfter(element.next('.select2-container'));
                  }
                  else{
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
          $('form[id="aadhar"]').validate({
              ignore: 'input[type=hidden], .select2-input, .select2-focusser',
              rules: {
                  adhar: 'required',
                  otp: 'required',
              },
              messages: {
                  adhar: 'This Aadhar Number is required',
                  otp: 'This OTP is required',
  
              },
              errorPlacement: function(label, element) {
                      label.addClass('mt-2 text-danger');
                  if(element.hasClass('form-select') && element.next('.select2-container').length) {
                  label.insertAfter(element.next('.select2-container'));
                  }
                  else{
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
          $('form[id="pan"]').validate({
              ignore: 'input[type=hidden], .select2-input, .select2-focusser',
              rules: {
                pan: 'required',
              },
              messages: {
                pan: 'This PAN Number is required',
  
              },
              errorPlacement: function(label, element) {
                      label.addClass('mt-2 text-danger');
                  if(element.hasClass('form-select') && element.next('.select2-container').length) {
                  label.insertAfter(element.next('.select2-container'));
                  }
                  else{
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
  </script>


@endsection
