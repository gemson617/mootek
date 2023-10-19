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

							<h3 class="">Quotation Management</h3>
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
								<a href="{{route('quotation.add')}}" class="btn-"  aria-expanded="false">
                                <button class="btn btn-primary">Add Quotation</button><i class="la la-plus"></i>
								</a>
							</li>
						</ul>
					</div>
                </div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<h5 class="card-header">Quotation  List</h5>
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">

                                        <table id="datatable_purchase" class="table  ">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S.No</th> -->
                                                    <th>ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Service</th>
                                                    <th>Quotation</th>
                                                    <!-- <th>Email</th> -->
                                                    <!-- <th>View</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $val)
                                                <tr>
                                                    <!-- <td>{{$loop->iteration}}</td> -->
                                                    <td>{{$val->invoice}}</td>
                                                    <td>{{$val->name}}</td>
                                                    <td>{{$val->gsttaxamount}}</td>
                                                    <td><a  target="_blank" href="{{route('quotation.quotation_print', $val->q_id)}}"><button class="btn btn-success">Quotation</button></a></td>
                                                                                             
                                                  <!-- <td><a href="{{route('quotation.list', $val->q_id)}}"><i class="fa fa-eye" style="font-size:22px;color:#0041ff;"></i></a></td> -->
                                                    <td>
                                                        @if($val->qt_status =='0')
                                                            <a href="{{route('quotation.edit', $val->q_id)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                                            <i class="fa fa-trash delete_modal"  id="{{$val->q_id}}" style="font-size:22px;color:red"></i>
                                                        @else
                                                        <i class="fa-solid fa-circle-check text-primary"></i>

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


$(".submit_event").click(function() {
      // Your click event logic here
      $("#proforma").submit();
    });
    

$(document).ready(function() {
    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);

    $('#datatable_purchase').dataTable( {
      "ordering": false
    } );

    $(".delete_modal").click(function() {
                id = $(this).attr("id");
                // alert(id);
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
                    url: "{{ route('quotation.quotation_delete') }}",
                    success: function(data) {
                        $("#delete_modal").modal('hide');
                        document.location.reload()
                    }
                });
            });


});

</script>



@endsection