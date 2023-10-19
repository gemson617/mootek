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
									ADD Rental <i class="la la-plus"></i>

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
									<h5 >Agreement List</h5>
                                    <div class="ml-auto ">
                                    <!-- <i class="fa fa-circle" aria-hidden="true" style="color :white; -webkit-text-stroke: 1px black;"></i><i class="fa">&nbsp; Normal Products</i> -->
                                    </div></div>
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">

                                    <table id="datatable_purchase" class="table ">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S.No</th> -->
                                                    <th>In.NO</th>
                                                    <th>Rental Date</th>
                                                    <th>Cus. Name</th>
                                                    <th>Renewal type</th>
                                                    {{-- <th>Rental Date</th> --}}
                                                    <th>Close  Date</th>
                                                    <th>View</th>
                                                    <th>Agreement</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $val)
                                                <?php
                                               
                                                    $rent_date =  date('d-m-Y', strtotime($val->rental_date));
                                                    $alert_date =  date('d-m-Y', strtotime($val->renewal_date));
                                                    $close_date =  date('d-m-Y', strtotime($val->receive_date));
                                                    $today = date('y-m-d');
                                                ?>
                                                <tr>
                                                    <!-- <td>{{$val->r_id}}</td>                                                    -->
                                                    <td>{{$val->rentalID}}</td>

                                                    <td>{{$rent_date}}</td>
                                                    <td>{{$val->name}}</td>
                                                    <td>{{$val->nos_day_week_month}} - {{$val->day_week_month}} </td>
                                                       {{-- <td>{{$alert_date}}</td> --}}
                                                       <td>{{$close_date}}</td>
                                                       <td><a href="{{route('rent.rent_view', $val->r_id)}}"><i class="fa fa-eye" style="font-size:22px;color:#0041ff;"></i></a></td>
                                                    <td align="center"><a target="_blank" href="{{route('rental.agreement', $val->r_id)}}"><i class="fas fa-file-contract" style="font-size:22px;color:#f89344"></i></a></td>
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



    <div class="modal fade" id="renuwalModal"  role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header bg-warning p-3">
                <h5 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Renuwal
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#">
                    @csrf
                    <input type="hidden" name="invoice_id" id="invoice_id" />
                <div class="row">
                    <div class="mb-3">
							<label for="validationCustomUsername">Date</label>
							<input type="date" class="form-control" id="renewal_date" name="renewal_date" placeholder="" >
					</div>


                    <div class=" mb-3">
							<label >Day/Week/Month </label>
							<select style="width:80px;" class="form-control" id="dayweekmonth" name="dayweekmonth">
                            <option value="">--Select--</option>
                            <option value="Day">Day</option>
                            <option value="Weeek">Weeek</option>
                            <option value="Month">Month</option>
                            </select>
					</div>

                    <div class="mb-3">
                        <label>D/W/M</label>
                        <select name="rent_month" id="rent_month" class="form-select selectDrop" >
                        <option value=''>--select--</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                            <?php if(isset($employee)){ foreach($employee as $row){ ?>
                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm">Renuwal</button>
                      </div>
                </form>



            </div>
        </div>
    </div>
</div>

<script>



function renuwal(val){
    $('#renuwalModal').modal('show');
    $('#invoice_id').val(val);
    // $('#employee_id');
    console.log(val)
    $("#rent_month").select2({
    dropdownParent: $("#renuwalModal"),
    width: '100%'
  });

  $("#dayweekmonth").select2({
    dropdownParent: $("#renuwalModal"),
    width: '100%'
  });
}


$(document).ready(function() {
    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);

    $('#datatable_purchase').DataTable({
        ordering:false
    });

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