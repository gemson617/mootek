@extends('layouts.app')

@section('content')
    <div class="app-content page-body">
        <div class="container">
            <div class="">
                <?php /*@include('layouts.partials.menu')*/ ?>

                <div class="row pb-5">

                    <div class="col-sm-12">
                        <div class="card border-left-primary shadow h-100 ">
                            <div class="card-header">
                                <h3 class="card-title">Add Call</h3>
                            </div>

                            <div class="card-body">

                                @if (session('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-warning" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form id="form" method="post" action="{{ route('sale.sale_store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Call Received Date</label>
                                            <input type="date" class="form-control " id="callrevdate" autocomplete="off">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Name</label>
                                            <input type="text" class="form-control " id="name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Phone Number</label>
                                            <input type="text" class="form-control" id="phnumber" placeholder="Enter Phone Number">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Complaint</label>
                                            <input type="text" class="form-control" id="complaint" placeholder="Enter Complaint">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Call Closed Date</label>
                                            <input type="date" class="form-control " id="closedate"  autocomplete="off">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Call source</label>
                                            <input type="text" class="form-control" id="callsource" placeholder="Enter Call source">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Payment collected</label>
                                            <input type="text" class="form-control" id="paymentcollected" placeholder="Enter Payment Collected">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Mode of Payment</label>
                                            <select class="form-control" id="mop">
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                                <option value="UPI">UPI payments</option>
                                                <option value="UPI">Bank Transfer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Employee name</label>
                                            <select class="form-control " id="empname">
                                                <option value=" ">--Select--</option> 
                                            </select>                                               
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label >Status </label>
                                            <select class="form-control " id="status">
                                                <option value=" ">--Select--</option>
                                                <option value="Open">Open</option>
                                                <option value="Close">Close</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label for="validationCustom01">Description</label>
                                            <textarea class="form-control" id="calldesc" placeholder="Enter Description"></textarea>
                                        </div>
                                    </div>                                   
                                    </div>
                                    <div class="card-footer bg-light">
                                        <button class="btn btn-primary" id="add_expense" onclick="myFunction()">Add Call</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {

            $("#tax_change").change(function() {
                taxable_price = parseInt($("#tax_price").val());
                tax = parseInt($('#tax_change').val());
                discount = $("#discount").val();
                console.log(taxable_price);

                $.ajax({

                    url: '{{ route('load.tax.grand') }}',

                    type: 'POST',

                    data: {

                        price: taxable_price,
                        tax: tax,
                        discount: discount,

                        "_token": "{{ csrf_token() }}",


                    },

                    beforeSend: function() {

                        $('body').css('cursor', 'progress');

                    },

                    success: function(data) {
                        $("#grand_total").val(data.total)
                    },

                    async: false

                });


            });
            $(".modal_change").change(function() {
                var product_id = $('.modal_change').val();
                console.log(product_id);
                $.ajax({
                    url: '{{ route('load.product') }}',
                    type: 'POST',
                    data: {

                        id: product_id,
                        "_token": "{{ csrf_token() }}",
                    },

                    beforeSend: function() {

                        $('body').css('cursor', 'progress');

                    },

                    success: function(data) {
                        console.log(data.serial_number.serial);
                        $("#loadProduct").val(data.category.category_name);
                        $("#loadBrand").val(data.brand.brand_name);
                        $("#loadPName").val(data.product.productName);
                        $("#loadPDes").val(data.product.description);
                        $("#loadPrice").val(data.product.selling_price);
                        $("#loadQuantity").val('1');
                        $("#serial_name").val(data.serial_number.serial);
                        if (data.serial_number.serial == null) {
                            $("#loadCheck").val('0');
                        } else {
                            $("#loadCheck").val('1');
                        }

                        // alert(data);

                        $('#snackbar').html("Product Added Successfully!");



                        $('body').css('cursor', 'default');

                    },

                    async: false

                });


            });
            $('#discount').on('input', function(e) {
                tax = $('#tax_price').val();
                dis = tax - $(this).val();
                $("#grand_total").val(dis);
            });


            setTimeout(function() {
                $(".alert-danger").slideUp(500);
                $(".alert-success").slideUp(500);
            }, 2000);



            $(".edit_form").click(function() {
                $("#form").load("content.html");
                id = $(this).val();
                $.ajax({
                    type: 'get',
                    data: {
                        id: id
                    },
                    url: "{{ route('brand.brand_index') }}",
                    success: function(data) {


                        $("#categoryID").val(data.data.categoryID);
                        $("#name").val(data.data.name);

                        $(".card-title").html('Edit Brand').css('color', 'red');
                        $("#id").val(data.data.id);
                        $("#categoryID").focus();
                        scrollToTop();
                    }
                });
            });


            $(".delete_modal").click(function() {
                id = $(this).val();
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
                    url: "{{ route('sale.sale_delete') }}",
                    success: function(data) {
                        $("#delete_modal").modal('hide');
                        document.location.reload()
                    }
                });
            });

            $('#datatable').DataTable({
                "ordering": false
            });

        });
    </script>
@endsection
