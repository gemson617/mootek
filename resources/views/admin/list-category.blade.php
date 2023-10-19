@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">

        <?php /*@include('layouts.partials.menu') */?>
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Product Categories</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Product Categories</a></li>
                </ol>
            </div>
            <div class="page-rightheader">
                @permission('add-category')
                <button type="button" class="btn btn-sm btn-primary mr-2"><i class="fe fe-plus mr-2"></i><a
                        href="{{ route('admin.product') }}" class="text-white">Add New Category</a></button>
                        @endpermission
                <button type="button" onclick="printDiv('show_default')"  class="btn btn-sm btn-primary mr-2"><i class="fa fa-print mr-1"></i><a href="#"
                        class="text-white">Print</a></button>

                <button type="button" onclick="importexcel()" class="btn btn-sm btn-success"><i class="fe fe-file mr-1"></i><a href="#"
                        class="text-white">Export</a></button>
            </div>
        </div>
        <!--End Page header-->


        @if (session('msg'))
        <div class="alert alert-success" role="alert">
            {{ session('msg') }}
        </div>
        @endif
        <br>

        <div class="col-sm-12">
            <div id="show_default"  class="">
                <table  class="table table-striped table-bordered" style="width:30%;">
                    <thead class="bg-azure-lighter">
                        <tr>
                            <th class="text-capitalize">Category Name</th>
                            <th class="text-capitalize" style="max-width:300px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>

                            <td>{{ $row->category_name }}</td>
                            <td class="text-right">
                                @permission('edit-category')
                                <a  href="javascript:void(0)" onclick="edit_category('<?php echo $row['id']; ?>')" class="btn btn-sm btn-success">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                @endpermission
                                @permission('remove-category')
                                <a  href="javascript:void(0)" onclick="delete_category('{{$row->id}}')"
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
</div>
<!----------------------------------edit product name description starts---------------------------------------->
<!-- Update Product Contents modal -->
<div class="modal fade" id="edit_pname" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning p-3">
                <h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Edit Category
                    Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('inventory.edit_category_name')}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id" id="category_id"
                        value="{{ isset($product->id) ? $product->id : 0}}" />
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Name</label>
                            <input type="text" class="form-control" id="pname" name="name" value="{{isset($product->name) ? $product->name:''}}">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------------------edit product name description starts---------------------------------------->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">

<!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>

setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
function importexcel() {

var a = document.createElement('a');
//getting data from our div that contains the HTML table
var data_type = 'data:application/vnd.ms-excel';
a.href = data_type + ', ' + encodeURIComponent($('div[id$=show_default]').html());
//setting the file name
a.download = 'CategoryList<?php echo date('d-m-Y'); ?>.xls';
//triggering the function
a.click();
//just in case, prevent default behaviour
// e.preventDefault();
return (a);

}
function edit_category(id) {
//alert(id);
            $.ajax({
                type: "POST",
                url: '{{route("admin.get_cname")}}',
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data) {
                        $('#category_id').val(data.id);
                        $('#pname').val(data.category_name);
                        $('#edit_pname').modal('show');
                    }
                },
                error: function(data, textStatus, errorThrown) {


                },
            });
        }
function delete_category(id) {
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
                url: '{{route("admin.delete-category")}}',
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data == 1) {
                        window.location = 'list-category';
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
