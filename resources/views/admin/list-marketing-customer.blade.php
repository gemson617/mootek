@extends('layouts.app')

@section('content')
<div class="app-content page-body">
	<div class="container">

                  @include('layouts.partials.menu')

                @if (session('msg'))
							<div class="alert alert-success" role="alert">
								{{ session('msg') }}
							</div>
						@endif

          <!--Page header-->
          <div class="page-header">
                                <div class="page-leftheader">
                                    <h4 class="page-title">Customer Marketing</h4>
                                    <ol class="breadcrumb pl-0">
                                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                        <li class="breadcrumb-item"><a href="#">Customer Marketing</a></li>
                                    </ol>
                                </div>
                                <div class="page-rightheader">
                                    @permission('add-marketing')
                                    <button type="button" class="btn btn-sm btn-primary mr-1"><i
                                            class="fe fe-plus mr-2"></i><a href="{{ route('admin.marketing-customer') }}" class="text-white">Add
                                            Marketing</a></button>
                                            @endpermission
                                            <button type="button"
                                        class="btn btn-sm btn-primary mr-1"><i class="fa fa-print mr-1"></i><a href=""
                                            class="text-white">Print</a></button> <button type="button"
                                        class="btn btn-sm btn-success"><i class="fe fe-file mr-1"></i><a href=""
                                            class="text-white">Export</a></button>
                                </div>
                            </div>
                            <!--End Page header-->

                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <div class="">
                                        <table id="example" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-azure-lighter">
                                                <tr role="row">
                                                    <th class="text-capitalize sorting_asc" tabindex="0"
                                                        aria-controls="example" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending">How
                                                        Customer Heard About Agas</th>


                                                    <th class="text-capitalize sorting text-center" tabindex="0"
                                                        aria-controls="example" rowspan="1" colspan="1"
                                                        aria-label="Actions: activate to sort column ascending"> Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $row)
                                                <tr>
                                                    <td>{{ $row->about_agas }}</td>
                                                    <td class="text-right">
                                                        <!-- <button type="button" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye fa-sm"></i>
                                                            <a href="#" class="text-white">View</a>
                                                        </button> -->
                                                        @permission('eidt-marketing')
                                                        <a href="edit-marketing-customer/{{$row->id}}" class="btn btn-sm btn-success">
                                                            <i class="fa fa-pencil"></i>
                                                           Edit
                                                        </a>
                                                        @endpermission
                                                        @permission('delete-marketing')
                                                        <a href="javascript:void(0)" onclick="delete_marketing('{{$row->id}}')"  class="btn btn-sm btn-danger">
                                                            <i class="fa fa-times"></i>
                                                            Delete
                                                        </a>
                                                        @endpermission
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>

	 setTimeout(function () {
      	$(".alert-danger").slideUp(500);
		  $(".alert-success").slideUp(500);
      }, 2000);

      function delete_marketing(id){
         swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
               $.ajax({
                  type: "POST",
                  url: '{{route("admin.delete-marketing-customer")}}',
                  data: { id:id, _token: '{{csrf_token()}}' },
                  success: function (data) {
                    if(data==1){
                     window.location='list-marketing-customer';
                    }
                  },
                  error: function (data, textStatus, errorThrown) {


                  },
               });
            }
        });
      }


</script>
@endsection
