@extends('layouts.app')

@section('content')


<div class="content-wrapper">
			<div class="content container">
				<!--START PAGE HEADER -->

				<section class="page-content mt-6 ">
                <div class="mt-8">

               
					<div class="d-flex align-items-center">
						<div class="mr-auto">

							<!-- <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index-2.html"><i class="icon dripicons-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:void(0)">Master </a></li>
									<li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
								</ol>
							</nav> -->
						</div>
						<ul class="actions top-right">
							<li class="dropdown">
								<a href="{{route('rental.rental_index')}}" class="btn "  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Rental <i class="la la-plus"></i>

                                    </button>
								</a>
							</li>
						</ul>
					</div>
                </div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<h5 class="card-header">Renewal List</h5>
									<div class="card-body">
                                        @if (session('msg'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('msg') }}
                                        </div>
                                    @endif
                                    <div class="row">
                                        {{-- <form action=""> --}}

                                        {{-- <div class="row">
                                            <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="date" id='id' placeholder="yyyy-mm-dd" class="form-control    @error('startDate') is-invalid @enderror" value="<?php echo date('Y-m-d'); ?>" name="id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-sm btn-success mr-1">check date wish</button>
                                                </div>

                                            </div> --}}
                                        {{-- </form> --}}

                                        </div>
                                    <div class="row pb-5">
                                      
                                    <table id="datatable_purchase" class="table ">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S.No</th> -->
                                                    <th>Inv.No</th>
                                                    <th>Rental Date</th>
                                                    <th>Renewal Date</th>
                                                    <th width='15%'>Cus. Name</th>
                                                    <th>Rental Type</th>
                                                    <th>T.Price</th>
                                                    <th>Disc</th>
                                                    <th>Tax(%)</th>
                                                    <th>G.Total</th>
                                                    <th>Renewal</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $currentDate = date("Y-m-d");
                                                @endphp
                                                @foreach($data as $val)
                                                
                                                @if (strtotime($val->renewal_date) <= strtotime($currentDate))
                                                <tr>
                                                    <!-- <td>{{$val->r_id}}</td>                                                    -->
                                                    <td>{{$val->rentalID}}</td>
                                                    <?php
                                                    $time =  date('d-m-Y', strtotime($val->rental_date));
                                                    ?>
                                                    <td>{{$time}}</td>
                                                   <?php
                                                    $time =  date('d-m-Y', strtotime($val->renewal_date));
                                                    ?>
                                                    <td>{{$time}}</td>
                                                    <td>{{$val->name}}</td>
                                                    <td>{{$val->nos_day_week_month}} - {{$val->day_week_month}} </td>
                                                    <td>{{number_format($val->taxable_amount,2)}}</td>
                                                    <td>{{$val->discount}}</td>
                                                    <td>{{$val->taxpercentage}}</td>
                                                    @php
                                                        $grand_total = ($val->taxable_amount-$val->discount)+(($val->taxable_amount-$val->discount)*$val->taxpercentage/100);
                                                    @endphp
                                                    <td>{{number_format($grand_total,2)}}</td>
                                                    <td><button class=" btn btn-primary payment_mode" id='' data='{{$val->r_id}}'>Remainder</button></td>
                                                </td>
                                                </tr>  
                                                @endif
                                         
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Renewal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id='payment_mode' action="{{route('renewal.payment')}}" method="post">
            @csrf
        <div class="modal-body">
            <div class="row">
            <div class="form-group mb-3">
                <label for="validationCustomUsername">Desposit Amount</label>
                <input type="hidden" id='rent_id' name='id'>
                <input type="hidden" id='grand' >
                <input type="text" class="form-control   @error('rent_date') is-invalid @enderror" id="deposit" name="deposit" placeholder="" readonly >
        </div>
        <div class="form-group mb-3 re_status">
            <label for="validationCustomUsername">If Deposit Amount Select 'YES',else if Enter Payment 'NO'</label>
            <select class="form-select" id="deposit_satus" name="deposit_satus">
                <option value="">--Select--</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
                {{-- <option value="2">Discard</option> --}}

            </select>
        </div>
        <div class="form-group mb-3 payment_type d-none re_status">
            <label for="validationCustomUsername">Payment Type</label>
            <select class="form-select" id="payment_mode_status" name="payment_mode_status" >
                <option value="">--Select--</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="UPI Payment">UPI Payment</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>
        <div class="form-group mb-3 d-none d_status re_status">
            <label for="validationCustomUsername d-none">Collected Amount</label>
            <input type="text" class="form-control   @error('rent_date') is-invalid @enderror" id="collected" name="collected" placeholder="" required >
        </div>
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data='1' id="continue_renewal">Continue Renewal</button>
          <button type="button" class="btn btn-success" data='1' id='received'>Received</button>
        </div>
    </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="r_material" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1400;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Received Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" value="" id='recei'>
          Are you Sure to Received Material ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info re_material">Yes,Received</button>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="continue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1400;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Renewal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" value="" id='re_d_v'>
          Are you Sure to Continue Renewal ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info con_renewal">Yes,Continue</button>
        </div>
      </div>
    </div>
  </div>


<script>
        $("#received").click(function(){
     check =$(this).attr('data');
     de=$("#deposit").val();

       if(check==1){
        $("#recei").val(de);
        $("#r_material").modal('show');
       }else{
    //    $(".re_status").addClass('d-none');
       $("#payment_mode").submit();
       }
    });

    $(".re_material").click(function(){
         validator.resetForm();
        $("#payment_mode")[0].reset();
      $('#received').removeAttr("type").attr("type", "submit");
      $('#continue_renewal').removeAttr("type").attr("type", "button");
       $("#payment_mode").submit();
       $('#continue_renewal').attr('data',1);
       $('#received').attr('data',0);
       $("#r_material").modal('hide');
       de=$("#recei").val();
       $("#deposit").val(de);
       $(".re_status").addClass('d-none');
    });
    
    $("#continue_renewal").click(function(){
       check =$(this).attr('data');
        de=$("#deposit").val();
       if(check==1){
        // $(".re_status").removeClass('d-none');
        $("#re_d_v").val(de);
        $("#continue").modal('show');
       }else{
       $("#payment_mode").submit();
       }
    });
    // $("#continue_renewal")
    $(".con_renewal").click(function(){
        validator.resetForm();
        
        $("#payment_mode")[0].reset();
        $(".re_status").removeClass('d-none');
      $('#continue_renewal').removeAttr("type").attr("type", "submit");
      $('#received').removeAttr("type").attr("type", "button");
       $("#payment_mode").submit();
       $('#continue_renewal').attr('data',0);
       $('#received').attr('data',1);
       de=$("#re_d_v").val();
       $("#deposit").val(de);
       $("#continue").modal('hide');
    });

    $(".payment_mode").click(function() {
        validator.resetForm();
        $('#continue_renewal').removeAttr("type").attr("type", "button");
     $('#received').removeAttr("type").attr("type", "button");
     $('#continue_renewal').attr('data',1);
     $('#received').attr('data',1);
        $("#collected").parent().addClass('d-none');
        if ($('#deposit_satus').data('select2')) {
     $('#deposit_satus').select2('destroy');

    }
    if ($('#pickup_status').data('select2')) {
     $('#pickup_status').select2('destroy');
    }
    if ($('#payment_mode_status').data('select2')) {
     $('#payment_mode_status').select2('destroy');
    }
    
    $("#deposit_satus").val('');
    // $("#deposit_satus").select2('destroy'); 
    id=$(this).attr('data');
    $("#rent_id").val(id);
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url:"/get_rental/"+id,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $("#deposit").val(data.data.deposit_amount);
            $("#grand").val(data.data.rental_amount);
        },error:function(){ 
             console.log(data);
        }
    });
     $("#exampleModal").modal('show');

});

        $('#deposit_satus').on('change', function() {
        id = $(this).val();
        deposit =$("#deposit").val();
        grand=$("#grand").val();
        console.log(grand);
        if(id =='1'){
            if(grand>=deposit){
            collected =grand-deposit;
            $(".pickup_c_status").addClass('d-none');
            $(".d_status").removeClass('d-none');
            $("#collected").attr('min',collected);
            $("#collected").attr('max',collected);
            $(".payment_type").addClass('d-none');

            
        }else if(grand <deposit){
            collected =deposit-grand;
            $(".pickup_c_status").addClass('d-none');
            $(".d_status").removeClass('d-none');
            $("#collected").attr('min',grand);
            $("#collected").attr('max',grand);
            $(".payment_type").addClass('d-none');

        }
        }else if(id=='0'){
            $(".pickup_c_status").addClass('d-none');
           $(".d_status").removeClass('d-none');
            $("#collected").attr('min',grand);
            $("#collected").attr('max',grand); 
            $(".payment_type").removeClass('d-none');

      }else{
        $(".d_status").addClass('d-none');
        $(".pickup_c_status").removeClass('d-none');
      }
         
        $("#form_submit").submit();

    });

    $('#pickup_status').on('change', function() {
        id = $(this).val();
       if(id ==1){
        $(".pickup").removeClass('d-none');
       }else{
        $(".pickup").addClass('d-none');

       }

    })

                        // VALIDATION ON FORM SUBMIT
                        validator=    $('form[id="payment_mode"]').validate({

rules: {
    // deposit: 'required',
    // balance: 'required',
    deposit_satus: 'required',
    // collected: 'required',
    pickup_status:'required',
    payment_mode_status:'required',

    
        },
        messages: {
            // deposit: 'This customer is required',
            // balance: 'This rent date is required',
            deposit_satus: 'Select Deposit Status',
            pickup_status: 'Select Pickup Status',
             payment_mode_status:'Payment Type is Required',


    // collected: 'required',
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
// You can submit the form or perform other actions here

}
});





$(document).ready(function() {
    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);

    $('#datatable_purchase').DataTable({
        ordering:false
    });

    $(document).on('click','.delete_modal',function(){
    // $(".delete_modall").click(function(){
         var  id=this.id;
            // alert(id);

             $("#delete_id").val(id);
          $("#delete_modal").modal('show');

        });
        $("#delete").click(function(){

            id=$('#delete_id').val();
            $.ajax({
                url:"{{route('rent.rental_delete')}}",
               type:'post',
               data:{
                "_token": "{{ csrf_token() }}",
                id:id,

               } ,

               success: function(data)
                {
                   $("#delete_modal").modal('hide');
                   document.location.reload();
                }
            });
        });



});

</script>



@endsection