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
									<h5 class="card-header">Rental Invoice List</h5>
									<div class="card-body">
                                        @if (session('msg'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('msg') }}
                                        </div>
                                    @endif
                                    <div class="row">
                                        <form action="">
                                        <div class="row">
                                           
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="date" id='startDate' placeholder="yyyy-mm-dd" class="form-control    @error('startDate') is-invalid @enderror" value="<?php echo date('Y-m-d'); ?>" name="id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-sm btn-success mr-1">check date wish</button>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    <div class="row pb-5">
                                      
                                    <table id="datatable_purchase" class="table ">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S.No</th> -->
                                                    <th>Inv.No</th>
                                                    <th>Rental Date</th>
                                                    <th>Due Date</th>
                                                    <th width='10%'>Cus. Name</th>
                                                    <th>During Period</th>
                                                    <th>Deposit</th>
                                                    <th>T.Price</th>
                                                    <th>Disc</th>
                                                    {{-- <th>Tax(%)</th> --}}
                                                    <th>G.Total(18%)</th>
                                                    <th>Colle</th>
                                                    <th>Bal</th>
                                                    <th>Paid/no Paid</th>
                                                    <th>payment</th>
                                                    <th>invoice</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $val)
                                                <tr>
                                                    <!-- <td>{{$val->r_id}}</td>                                                    -->
                                                    <td>{{$val->rentalID}}</td>
                                                   <?php
                                                    $time =  date('d-m-Y', strtotime($val->rental_date));
                                                    ?>
                                                    <td>{{$time}}</td>
                                                    <td>{{$val->receive_date}}</td>
                                                    <td>{{$val->name}}</td>
                                                    <td>1 - {{$val->day_week_month}} </td>
                                                    <td>{{$val->d_amt}}</td>
                                                    <td>{{number_format($val->taxable_amount,2)}}</td>
                                                    <td>{{$val->discount}}</td>
                                                    {{-- <td>{{$val->taxpercentage}}</td> --}}
                                                    <td>{{number_format($val->total_amount,2)}}</td>
                                                    <td>{{number_format($val->collected,2)}}</td>
                                                    <td>{{number_format($val->balance,0)}}</td>
                                                    <td>
                                                        @if ($val->payment_status ==0)
                                                        <span class="text-primary">
                                                            <i class="fa fa-circle"></i>No Paid
                                                        </span>
                                                            @else
                                                            <span class="text-success">
                                                                <i class="fa fa-check-circle"></i> Paid
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($val->payment_status ==0)
                                                        <button class=" btn btn-primary payment_mode" id='' data='{{$val->r_id}}'>payment</button></td>

                                                            @else
                                                            -
                                                        @endif
                                                    </td>
                                                        {{-- @if ($val->payment_status ==0) --}}
                                                              {{-- <td> -</td> 
                                                            @else --}}
                                                            <td><a href="{{route('rental.rental_bill', $val->r_id)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a></td>

                                                        {{-- @endif --}}
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
					</section>
				</div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id='payment_mode' action="{{route('rent.payment')}}" method="post">
            @csrf
        <div class="modal-body">
            <div class="row">
            <div class="form-group mb-3">
                <label for="validationCustomUsername">Desposit Amount</label>
                <input type="hidden" id='rent_id' name='id'>
                <input type="hidden" id='tax_amt' name="taxable_amount">
                <input type="hidden" id='disc' name="discount">
                <input type="hidden" id='tax_p' name="taxpercentage">
                
                <input type="text" class="form-control   @error('rent_date') is-invalid @enderror" id="deposit" name="deposit" placeholder="" readonly >
        </div>
        <div class="form-group mb-3">
            <label for="validationCustomUsername">Invoice Amount</label>
            <input type="text" class="form-control   @error('rent_date') is-invalid @enderror" id="balance" name="balance" placeholder=""  readonly>
        </div>
        <div class="form-group mb-3">
            <label for="validationCustomUsername">If Deposit Amount Select 'YES',Otherwise 'NO'</label>
            <select class="form-select" id="deposit_satus" name="deposit_satus">
                <option value="">--Select--</option>
                <option value="1">Yes</option>
                <option value="0">No</option>

            </select>
        </div>
        <div class="form-group mb-3 payment_type d-none">
            <label for="validationCustomUsername">Payment</label>
            <select class="form-select" id="payment_mode_status" name="payment_mode_status" >
                <option value="">--Select--</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="UPI Payment">UPI Payment</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>
        <div class="form-group mb-3 d-none">
            <label for="validationCustomUsername d-none">Collected Amount</label>
            <input type="text" class="form-control   @error('rent_date') is-invalid @enderror" id="collected" name="collected" placeholder="" required >
        </div>
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Yes,Continue</button>
        </div>
    </form>
      </div>
    </div>
  </div>

<script>
    $(".payment_mode").click(function() {
        $("#collected").parent().addClass('d-none');
        if ($('#deposit_satus').data('select2')) {
     $('#deposit_satus').select2('destroy');
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
            $("#deposit").val(data.data.deposit);
            $("#balance").val(data.data.balance);
            $("#tax_amt").val(data.data.taxable_amount);
            $("#disc").val(data.data.discount);
            $("#tax_p").val(data.data.taxpercentage);

                    // var rows = data.payment;
                    // console.log(rows);
                    // var options = [];
                    // for (var i = 0; i < rows.length; i++) {
                    //     options += "<option value=" + rows[i].id + ">" + rows[i].payment_mode + "</option>";
                    // }
                    // $('#payment_mode_status').append(options);
           console.log(data.data);
        },error:function(){ 
             console.log(data);
        }
    });
     $("#exampleModal").modal('show');

});

        $('#deposit_satus').on('change', function() {
        id = $(this).val();
        deposit =$("#deposit").val();
        balance=$("#balance").val();
        if(id =='1'){
          
        if(deposit>=balance){
            // collected =deposit-balance;
            $("#collected").parent().removeClass('d-none');
            $("#collected").attr('min',balance);
            $("#collected").attr('max',balance);
            $(".payment_type").addClass('d-none');

        }else if(deposit <balance){
            collected =balance-deposit;
            $("#collected").parent().removeClass('d-none');
            $("#collected").attr('min',collected);
            $("#collected").attr('max',collected);
            $(".payment_type").addClass('d-none');

        }
    }else{
           $("#collected").parent().removeClass('d-none');
            $("#collected").attr('min',balance);
            $("#collected").attr('max',balance); 
            $(".payment_type").removeClass('d-none');
      }
         
        $("#form_submit").submit();

    })

                        // VALIDATION ON FORM SUBMIT
                        $('form[id="payment_mode"]').validate({

rules: {
    // deposit: 'required',
    // balance: 'required',
    deposit_satus: 'required',
    payment_mode_status:'required'
    // collected: 'required',
        },
        messages: {
            // deposit: 'This customer is required',
            // balance: 'This rent date is required',
            deposit_satus: 'Select Deposit Status',
    payment_mode_status:'Payment Type is Required'

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