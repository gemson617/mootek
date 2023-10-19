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
                            <h4 class="page-title">Delivery Regions</h4>
                            <ol class="breadcrumb pl-0">
                                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                                <li class="breadcrumb-item"><a href="#">Delivery Regions</a></li>
                            </ol>
                        </div>
                        <div class="page-rightheader">
                            @permission('add-region')
                            <button type="button" class="btn btn-sm btn-primary mr-1"><i class="fe fe-plus mr-2"></i><a
                                    href="{{ route('admin.delivery-regions') }}" class="text-white">Add
                                    Region</a></button>
                                    @endpermission
                                    <button type="button" class="btn btn-sm btn-primary mr-1"><i
                                    class="fa fa-print mr-1"></i><a href="#" class="text-white">Print</a></button>
                            <button type="button" class="btn btn-sm btn-success"><i class="fe fe-file mr-1"></i><a
                                    href="#" class="text-white">Export</a></button>
                        </div>
                    </div>
                    <!--End Page header-->

                    <div class="row">
                        <div class="col-sm-2">
                            <h4 class="mb-5">Offices for Dispatch From</h4>
                            <div class="card bg-azure-lightest">
                                <div class="card-body">
                                    <div class="orderContentBox">
                                        <div class="">
                                            <table class="table table-bordered" >
                                                <tbody>
                                                    <?php $i=1; ?>
                                                    @foreach($office as $row)
                                                    <tr>
                                                        <td class="p-2">{{$row->address_name}}</td>
                                                        <td class="p-2">{{$row->id}}</td>
                                                    </tr>
                                                    @endforeach


                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="">
                                <table id="example" class="table table-striped table-bordered" style="width:auto;">
                                    <thead class="bg-azure-lighter">
                                        <tr role="row">
                                            <th class="text-capitalize sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 244px;" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Name</th>

                                            <th class="text-capitalize sorting_asc" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1" style="width: 244px;" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending">Dispatch
                                                from</th>
                                            <th class="text-capitalize sorting" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Actions: activate to sort column ascending">Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $row)
                                        <tr>
                                            <td class="sorting_1">{{ $row->name }}</td>
                                            <td class=" ">{{ $row->dispatch_from }}</td>
                                            <td class="text-right">
                                                <!-- <button type="button" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye fa-sm"></i>
                                                    <a href="#" class="text-white">View</a>
                                                </button> -->
                                                @permission('eidt-region')
                                                <a tool="Edit Regions" href="edit-delivery-regions/{{$row->id}}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                @endpermission
                                                @permission('delete-region')
                                                <a  tool="Edit Regions" href="javascript:void(0)" onclick="delete_delivery('{{$row->id}}')" type="button"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i>
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







            <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css"
                rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
            <script>

            setTimeout(function() {
                $(".alert-danger").slideUp(500);
                $(".alert-success").slideUp(500);
            }, 2000);

            function delete_delivery(id) {
                swal({
                    title: "Are you sure you want to delete this record?",
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    type: "warning",
                    buttons: ["Cancel", "Yes!"],
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            url: '{{route("admin.delete-delivery-regions")}}',
                            data: {
                                id: id,
                                _token: '{{csrf_token()}}'
                            },
                            success: function(data) {
                                if (data == 1) {
                                    window.location = 'list-delivery-regions';
                                }
                            },
                            error: function(data, textStatus, errorThrown) {


                            },
                        });
                    }
                });
            }
            </script>
            @endsection
