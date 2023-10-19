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
                <h4 class="page-title">Offices</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Offices</a></li>
                </ol>
            </div>
            <div class="page-rightheader">
                @permission('add-office')
                <button type="button" class="btn btn-sm btn-primary mr-1"><i class="fe fe-plus mr-2"></i><a href="{{ route('admin.office') }}"
                        class="text-white">Add
                        Office</a></button>
                        @endpermission
                        <button type="button" class="btn btn-sm btn-primary mr-1"><i
                        class="fa fa-print mr-1"></i><a href="" class="text-white">Print</a></button> <button
                    type="button" class="btn btn-sm btn-success"><i class="fe fe-file mr-1"></i><a href=""
                        class="text-white">Export</a></button>
            </div>
        </div>
        <!--End Page header-->

        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="">
                    <table id="example" class="table table-striped table-bordered" style="width:auto;">
                        <thead class="bg-azure-lighter">
                            <tr role="row">
                                <th class="text-capitalize sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending">
                                    Id</th>
                                <th class="text-capitalize sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="Name: activate to sort column descending">Depot Name</th>


                                <th class="text-capitalize sorting text-center" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">
                                    Street
                                    Name</th>

                                <th class="text-capitalize sorting text-center" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">
                                    Postcode
                                </th>
                                <th class="text-capitalize sorting text-center" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">
                                    Suburb
                                </th>
                                <th class="text-capitalize sorting text-center" tabreindex="0" aria-controls="example"
                                    rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr role="row" class="odd">
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->address_name }}</td>

                                <td>{{ $row->street_name }}</td>
                                <td>{{ $row->postcode }}</td>
                                <td>{{ $row->suburb }}</td>
                                {{-- @php
                                $suburb_name = App\Models\Suburb::where('id', $row->suburb)->pluck('name');
                                $trim = str_replace(['"',"'"], "", $suburb_name);
                                $arr = str_replace( array('[',']') , ''  , $trim );
                                @endphp

                                <td>{{ $arr }}</td> --}}

                                <td class="text-right">
                                    <!-- <button type="button" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye fa-sm"></i>
                                        <a href="#" class="text-white">View</a>
                                    </button> -->
                                    @permission('eidt-office')
                                    <button title="Edit Office" type="button" class="btn btn-sm btn-success">

                                        <a href="edit-office/{{$row->id}}" class="text-white"><i class="fa fa-pencil"></i></a>
                                    </button>
                                    @endpermission
                                    @permission('delete-office')
                                    <button title="delete Office" onclick="delete_office('{{$row->id}}')" type="button" class="btn btn-sm btn-danger">

                                        <a href="javascript:void(0)" class="text-white"><i class="fa fa-times"></i></a>
                                    </button>
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

setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);

function delete_office(id) {
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
                url: '{{route("admin.delete-office")}}',
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data == 1) {
                        window.location = 'list-office';
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
