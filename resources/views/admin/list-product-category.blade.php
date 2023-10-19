@extends('layouts.app')
@section('content')
{{-- <script>
    <?php
    if(isset($fields)){ ?>
        $('#search-frm').show();
    <?php }else{ ?>
        $('#search-frm').hide();
   <?php }
    ?>
</script> --}}

<div class="app-content page-body">
    <div class="container">

        <?php /*@include('layouts.partials.menu') */?>
        <!--Page header-->
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Inventory and Pricing</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory and Pricing</a></li>
                </ol>
            </div>

            <div class="page-rightheader">

            <a href="{{ route('admin.add-product') }}"  class="text-white btn btn-sm btn-primary mr-2"><i class="fe fe-plus mr-2"></i>Add New Product</a>

            <button type="button" class="btn btn-sm btn-primary mr-2"><i class="fa fa-print mr-1"></i><a href="#"
                        class="text-white">Print</a></button>

                <button type="button" class="btn btn-sm btn-success"><i class="fe fe-file mr-1"></i><a href="#"
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
                <div class="card bg-azure-lightest">
                    <div class="card-body pb-0">
                        <!-- <form class=""> -->
                        <h4 class="text-primary">Quick Search</h4>
                        <form enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="text" id="search" name="search"
                                    value=""
                                    class="form-control">
                                <div class="input-group-append">
                                    <button type="button" id="search" class="btn btn-primary "><i
                                            class="fa fa-search text-white"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="form-group mt-2">
                            <div class="panel-group" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default active border-0">
                                    <div class="panel-heading bg-transparent" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" onclick="showfrm()" data-toggle="collapse"
                                                data-parent="#accordion" href="#collapseOne" aria-expanded="false"
                                                aria-controls="collapseOne" class="p-0 border-0 text-danger collapsed">
                                                <i class="fe fe-edit fe-sm fe-fw ml-1 text-gray-600"></i> Advanced
                                                Search
                                            </a>
                                        </h4>
                                    </div><br>
                                    <!-- id="customerFormData" -->

                                    <form style="display: none;" id="advanceForm" class="advance_search"
                                        action="{{ route('gas-bottle.search') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12 d-flex flex-wrap flex-lg-nowrap">
                                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" onchange="productSearch()"  value="" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="-1">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">In-active</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Product Code</label><input onkeyup="productSearch()" id="code"  value="" type="text" name="code" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Product Description</label><input onkeyup="productSearch()" id="desc" name="desc" type="text"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" onchange="productSearch()" name="category" id="category">
                                                <option value="">Select Type</option>
                                                @foreach($category as $row)
                                                <option  value='{{$row->id}}'>{{ $row->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" name="type" onchange="productSearch()" id="type">
                                            <option value="">Select Type</option>
                                            <option value="1">CYLINDER</option>
                                            <option value="2">HARDGOOD RENTAL</option>
                                            <option value="3">HARDGOOD SALES</option>
                                            <option value="4">TRANSACTION</option>
                                            <option value="5">GAS</option>

                                        </select>
                                        </select>
                                    </div>
                                </div>
                            </div>




                                            <button style="display:none;" type="submit"
                                                class="form-control btn btn-primary mt-3 ml-2">Search</button>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>



        <div class="row">
            <div class="col-sm-12" id="appendTable">
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
                <h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-white">Edit Product
                    Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('inventory.edit_product_name')}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id"
                        value="{{ isset($product->id) ? $product->id : 0}}" />
                    <div class="row">

                        <div class="form-group col-sm-5">
                            <label>Name</label>
                            <input type="text" class="form-control" id="pname" name="name" value="{{isset($product->name) ? $product->name:''}}">

                        </div>
                        <div class="form-group col-sm-5">
                            <label>Code</label>
                            <input type="text" class="form-control" id="pcode" name="code" value="{{isset($product->product_code) ? $product->product_code:''}}">

                        </div>
                        <div class="form-group col-sm-5">
                            <label>Description</label>
                            <input type="text" class="form-control" id="pdescription" name="description" value="{{isset($product->description) ? $product->description:''}}">

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
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);

function showfrm() {
        $('.advance_search').slideToggle(500);
    }
    function productSearch() {
        var status = $('#status').val();
        var code = $('#code').val();
        var desc = $('#desc').val();
        var category = $('#category').val();
        var type = $('#type').val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.list-product-category') }}",
            data: {
                category: category,
                status: status,
                code: code,
                desc: desc,
                type: type,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                if (data) {
                    $('#appendTable').html(data);
                }
            },
            error: function(data, textStatus, errorThrown) {},
        });
    }

    $('#search').on('keyup',function(){
    var search=$('#search').val();
    $('#appendTable').html('');
    $.ajax({
        type: "POST",
        url: "{{ route('admin.list-product-category') }}",
        data: {
            search:search,
            _token: '{{csrf_token()}}'
        },
        success: function(data) {
            if(data) {
                $('#appendTable').html(data);
            }
        },
        error: function(data, textStatus, errorThrown) {},
    });
})

function edit_product_name(id) {
//alert(id);
            $.ajax({
                type: "POST",
                url: '{{route("admin.get_pname")}}',
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data) {
                        $('#product_id').val(data.id);
                        $('#pname').val(data.name);
                        $('#pcode').val(data.product_code);
                        $('#pdescription').val(data.description);
                        $('#edit_pname').modal('show');
                    }
                },
                error: function(data, textStatus, errorThrown) {


                },
            });
        }

function delete_product_category(id) {
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
                url: '{{route("admin.delete-product-category")}}',
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data == 1) {
                        window.location = '{{route("admin.list-product-category")}}';
                    }
                },
                error: function(data, textStatus, errorThrown) {


                },
            });
        }
    });
}

$('#show-search').on('click', function() {
      $('#search-frm').slideToggle(500);
   })
</script>
@endsection
