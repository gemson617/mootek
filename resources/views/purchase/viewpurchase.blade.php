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

							<h3 class="">Local Purchase  List</h3>
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
								<a href="{{route('add.purchase')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary logo'>
                                        <i class="mdi mdi-plus-circle"></i>
									Add Local
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
                                    <h5 class="">Local Purchase  List</h5>
                                   </div>
									<div class="card-body">
                                    <div class="row">
                                    <table id="datatable_purchase" class="table">
                                            <thead>
                                                <tr>
                                                    <th>PO No</th>
                                                    <th>Company Name</th>
                                                    <th>Pur. Date</th>
                                                     <th>Tax Price</th>
                                                     <th>Others</th>
                                                     <th>Cess</th>
                                                    <th>Tax(%)</th>
                                                    <th>Tax Amount</th>
                                                    <th>Grand Total</th>
                                                    <th>Payment</th>
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
                                                    <td>{{$val->tax_price}}</td>
                                                    <td>{{number_format($val->others,2)}}</td>
                                                    <td>{{number_format($val->cess,2)}}</td>
                                                    <td>{{$val->tax_amount_value}}</td> 
                                                    <td>{{number_format($val->tax_percent,2)}}</td> 
                                                    <td>{{number_format($val->grand_total,2)}}</td> 
                                                    <td>
                                                        <a href="{{route('purchase.payment',$val->id)}}"><button class="btn btn-success">payment</button></a>
                                                    </td>
                                                    <td>
                                                        @if ($val->payment_status =='0')
                                                       <a href="{{route('purchase.edit',$val->id)}}"><button class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
                                                       @endif
                                                       <a href="{{route('purchase.print',$val->id)}}"><button class="btn btn-info"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
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