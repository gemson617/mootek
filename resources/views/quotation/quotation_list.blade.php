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
									Add Quotation<i class="la la-plus"></i>
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
                                        <table id="datatable_purchase" class="table -table">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>                                                    
                                                    <th>Model</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $val)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$val->category_name}}-{{$val->brand_name}}-{{$val->productName}}</td>
                                                    <td>{{$val->description}}</td>
                                                    <td>{{$val->gstamount}}</td> 
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

    

   

});

</script>



@endsection