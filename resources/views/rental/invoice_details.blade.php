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

							<h4>Rental Management </h4>
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
									<h5 class="card-header">Invoice Details</h5>
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">

                                    <table id="datatable_purchase" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Product</th>
                                                    <th>Serial No</th>
                                                    <th>HSN</th>
                                                    <th>Description</th>
                                                    <th>Rental type</th>
                                                    <th>Rent Date</th>
                                                    {{-- <th>Rent Price</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $val)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$val->category_name}}/ {{$val->brand_name}} /{{$val->productName}}</td>
                                                    <td>{{$val->serialID}}</td>
                                                    <td>{{$val->hsn}}</td>
                                                    <td>{{$val->description}}</td>
                                                    <td>1 ({{$val->dayweekmonth}})</td>
                                                    <?php
                                                    $rent_date = date("d-m-Y", strtotime($val->rent_date));
                                                    ?>
                                                    <td>{{$rent_date }}</td>
                                                    <?php $tavable_amt = $val->rent_price * $val->tax / 100  ?>
                                                    {{-- <td>{{$tavable_amt}}</td> --}}
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

    $('#datatable_purchase').DataTable();

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