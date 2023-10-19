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

							<h3 class="">Purchase Stock List</h3>
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
                                
								<a href="{{route('purchase.purchase_index')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Purchase<i class="la la-plus"></i>

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
                                    <h5 class="">Purchase Stock List</h5>
                                    <div class="ml-auto ">
                                    <i class="fa fa-circle" aria-hidden="true" style="color :antiquewhite; -webkit-text-stroke: 1px black;"></i><i class="fa"></i>&nbsp; Bulk Products,
                                    <i class="fa fa-circle" aria-hidden="true" style="color :white; -webkit-text-stroke: 1px black;"></i><i class="fa"></i>&nbsp; Normal Products
                                    </div></div>


									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">

                                    <table id="datatable_purchase" class="table  table-Responsive nowrap">
                                            <thead>
                                                <tr>
                                                    <th>PO.No</th>
                                                    <th>Supplier</th>
                                                    <th>product</th>
                                                    <th>pur.Date</th>
                                                    <th>serial</th>
                                                    <th>hsn</th>
                                                    <th>Pur. Price</th>
                                                    <th>Sell. Price</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                                @foreach($data as $val)
                                                @if($val->serial != null)
                                                <tr>
                                                    <td>{{$val->po_no}}</td>
                                                    <td>{{$val->supplier_name}}</td>
                                                    <td>{{$val->category_name}} / {{$val->brand_name}} / {{$val->productName}} </td>
                                                    <?php
                                                    $purchasedate = date("d-m-Y", strtotime($val->purchaseDate));
                                                    ?>
                                                    <td>{{$purchasedate}}</td>
                                                    <td>{{$val->serial}}</td>
                                                    <td>{{$val->hsn}}</td>
                                                    <td align='right'>{{number_format($val->purchase_price,2)}}</td>
                                                    <td align='right'>{{number_format($val->selling_price,2)}}</td>
                                                      <!--<td>
                                                        <a target="_blank"  href="{{route('purchase.purchase_print', $val->po_no)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
                                                        <a href="{{route('purchase.purchase_edit', $val->po_no)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                                        <i class="fa fa-trash delete_modall"  id="{{$val->po_no}}" style="font-size:22px;color:red"></i>
                                                    </td> -->
                                                </tr>
                                                @else
                                                <tr style="background-color: antiquewhite;">
                                                    <td>{{$val->po_no}}</td>
                                                    <td>{{$val->supplier_name}}</td>
                                                    <td>{{$val->category_name}} / {{$val->brand_name}} / {{$val->productName}}  ({{$val->count}})</td>
                                                    <?php
                                                    $purchasedate = date("d-m-Y", strtotime($val->purchaseDate));
                                                    ?>
                                                    <td>{{$purchasedate}}</td>
                                                 
                                                    <td>--</td>
                                               

                                                    <td>{{$val->hsn}}</td>
                                                    <td align='right'>{{number_format($val->purchase_price,2)}}</td>
                                                    <td align='right'>{{number_format($val->selling_price,2)}}</td>
                                                      <!--<td>
                                                        <a target="_blank"  href="{{route('purchase.purchase_print', $val->po_no)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
                                                        <a href="{{route('purchase.purchase_edit', $val->po_no)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                                        <i class="fa fa-trash delete_modall"  id="{{$val->po_no}}" style="font-size:22px;color:red"></i>
                                                    </td> -->
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
<script>




$(document).ready(function() {
    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);


    $('#datatable_purchase').dataTable( {
      "ordering": false
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