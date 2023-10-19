@extends('layouts.app')

@section('content')


<div class="content-wrapper">
			<div class="content container">
				<!--START PAGE HEADER -->

				<section class="page-content mt-6 ">
                <div class="mt-8">
                @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
                @endif
					<div class="d-flex align-items-center">
						<div class="mr-auto">

							<h3 class="">Purchase  List</h3>
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
								<a href="{{route('add.importpurchase')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary logo'>
                                        <i class="mdi mdi-plus-circle"></i>
									Add import
                                    </button>
								</a>
							</li>
						</ul>
					</div>
                </div>
						<div class="row">
							<div class="col-12">
								<div class="card">
                                    <div class="card-header   d-flex align-items-center">
                                    <h5 class="">Purchase  List</h5>
                                   </div>
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">

                                    <table id="datatable_purchase" class="table  nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Inc.No</th>
                                                    <th>Company Name</th>
                                                    <th>Pur. Date</th>
                                                    <th>INR</th>
                                                     <th>Amount</th>
                                                     <th>Bank Fees</th>
                                                     <th>IGST Amount(18%)</th>
                                                    <th>Shipment Charges</th>
                                                    <th>Others Charges</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($datatable as $val)
                                                <tr>
                                                    <td>{{$val->invoiceID}}</td>
                                                    <td>{{$val->purchase_company}}</td>
                                                    <?php
                                                    $purchasedate = date("d-m-Y", strtotime($val->purchaseDate));
                                                    ?>
                                                    <td>{{$purchasedate}}</td>
                                                    <td>{{number_format($val->inr,2)}}</td>
                                                    <td>{{number_format($val->amount,2)}}</td>
                                                    <td>{{$val->bank_fees}}</td> 
                                                    <td>{{number_format($val->igst_amount,2)}}</td> 
                                                    @if ($val->mode =='ship')
                                                    <td>{{$val->do_charges_amount+$val->custom_com_amount+$val->cfs_charges_amount+$val->transport_c_amount}}</td>
                                                        @else
                                                       <td>-</td>
                                                    @endif
                                                    @if ($val->mode =='ship')
                                                    <td>{{number_format($val->agent_charges,2)}}</td> 
                                                        @else
                                                        <td>{{number_format($val->others_charges,2)}}</td> 
                                                    @endif
                                                   
                                                  
                                                    <td>
                                                        @if ($val->payment_status =='0')
                                                       <a href="{{route('importpurchase.edit',$val->id)}}"><button class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
                                                       @else
                                                       -
                                                       @endif
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
					</section>
				</div>
<script>




$(document).ready(function() {
    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);


    $('#datatable_purchase').dataTable( {
      "ordering": false,
      scrollX: true
    } );

    $(document).on('click','.delete_modall',function(){
    // $(".delete_modall").click(function(){
         var  id=this.id;
            //alert(id);
            // confirm("Confirm You Want to Delete!");

            // id=$(this).val();
             $("#delete_id").val(id);
          $("#delete_modal").modal('show');

        });
        $("#delete").click(function(){

            id=$('#delete_id').val();
            $.ajax({
                url:"{{route('purchase.view_delete')}}",
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