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
                                <h3 class="card-title">Generate QR</h3>
                            </div>

                            <div class="card-body">

                                @if (session('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                @endif
                                <form id="form" method="post" action="{{ route('generateCode') }}">
                                    @csrf
                                    <input type="hidden" id='id' name='id'>
                                    <div class="row">

                                        <!-- <div class="col-md-4">
                                            <label for="">Select Company<span class="error">*</span></label>
                                            <div class="form-group">
                                                <select  id='company' class="form-select txt-num  @error('company') is-invalid @enderror"  name="company" >
                                                <option value="">--Select--</option>
                                                @foreach ($company as $cdata)
    <option value="{{ $cdata->id }}">{{ $cdata->company }}</option>
    @endforeach
                                                </select>
                                                @error('company')
        <div class="error">*{{ $message }}</div>
    @enderror
                                            </div>
                                        </div> -->


                                        <div class="col-md-4">
                                            <label for="">Select Category<span class="error">*</span></label>
                                            <div class="form-group">
                                                <select id='categoryID'
                                                    class="form-select txt-num  @error('categoryID') is-invalid @enderror"
                                                    name="category_id">
                                                    <option value="">--Select--</option>
                                                    @foreach ($category as $cdata)
                                                        <option value="{{ $cdata->id }}">{{ $cdata->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('categoryID')
                                                    <div class="error">*{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Select Product<span class="error">*</span></label>

                                            <div class="form-group">
                                                <select id='brandID'
                                                    class="brand form-select txt-num  @error('brandID') is-invalid @enderror"
                                                    name="brand_id">
                                                    <option value="">--Select--</option>
                                                </select>
                                                @error('brandID')
                                                    <div class="error">*{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Prefix<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="text" id='prefix_no'
                                                    class="form-control txt-num @error('prefix_no') is-invalid @enderror"
                                                    name="prefix_no" />
                                                @error('prefix_no')
                                                    <div class="error">*The Model Name is required.</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Start No<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="number" id='start_no'
                                                    class="form-control txt-num @error('start_no') is-invalid @enderror"
                                                    name="start_no" />
                                                @error('start_no')
                                                    <div class="error">*The Model Name is required.</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <label for="">End No<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="number" id='end_no'
                                                    class="form-control num @error('end_no') is-invalid @enderror"
                                                    name="end_no" />
                                                @error('end_no')
                                                    <div class="error">*The Model Name is required.</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>




                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="/master-menus"
                                                class="relodad btn btn-sm btn-primary mr-1 cancel">Back</a>
                                            <button type="submit" class="btn btn-sm btn-success mr-1">GenerateQR</button>
                                            <a href="#" id="cancel"
                                                class="relodad  btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                            <button id="previewBtn" class="btn btn-info" type="button">Preview</button>
                                            <label id="preview"></label>
                                        </div>
                                    </div>
                            </div>

                            </form>
                        </div>
                    </div>

                </div>





                <div class="row pb-5">

                    <table id="datatable" class='table table-striped'>
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>prefix</th>
                                <th>Start No</th>
                                <th>End No</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($qrlist as $val)
                                <tr>
                                    <td> {{ $loop->iteration }}</td>
                                    <td> {{ $val->category_name }} - {{ $val->brand_name }} - {{ $val->productName }}</td>
                                    <td> {{ $val->prefix_no }}</td>
                                    <td> {{ $val->start_no }}</td>
                                    <td> {{ $val->end_no }}</td>
                                    <td> <a href="{{route('qrcode.qrview', $val->code_id)}}"><i class="fa fa-eye" style="font-size:22px;color:#0041ff;"></i></a>
                                        <a href="#"><i class="fa fa-trash delete_modal"  data="{{$val->code_id}}"
                                                style="font-size:22px;color:#9c0217;"></i></a>
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
    </div>


    <div class="modal fade" id="qrcodeModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning p-3">
                    <h4 id="exampleModalLabel" class="modal-title text-center font-weight-bold text-#6c757d">QR CODE
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assign_lead" >
                        @csrf
                       
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>


        function view(id) {
            $('#qrcodeModal').modal('show');
            $('#lead_id').val(id);
            // $('#employee_id');
            $("#employee_id").select2({
                dropdownParent: $("#leadModal"),
                width: '100%'
            });
        }
        $('form[id="form"]').validate({
            rules: {
                category_id: 'required',
                brand_id: 'required',
                prefix_no: 'required',
                start_no: 'required',
                end_no: 'required',
            },
            messages: {
                category_id: 'This   category is required',
                brand_id: 'This Product   is required',
                prefix_no: 'This  Prefix  is required',
                start_no: 'This Start No  is required',
                end_no: 'This End No is required',
            },
            errorPlacement: function(label, element) {
                label.addClass('mt-2 text-danger');
                if (element.hasClass('form-select') && element.next('.select2-container').length) {
                    label.insertAfter(element.next('.select2-container'));
                } else {
                    label.insertAfter(element);
                }
            },
            highlight: function(element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('form-control-danger')
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('has-danger')
                $(element).parent().removeClass('form-control-danger')
            },
            submitHandler: function(form) {

                form.submit();
            }

        });

        $('#previewBtn').on("click", function(data) {
            var brand = $('#brandID').val();
            var category = $('#categoryID').val();
            var company = $('#company').val();
            var prefix = $('#prefix_no').val();
            var start = $('#start_no').val();
            var end = $('#end_no').val();
            $('#preview').html('');
            $.ajax({
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    brand: brand,
                    category: category,
                    company: company,
                    prefix: prefix,
                    start: start,
                    end: end
                },
                url: "{{ route('previewQR') }}",
                success: function(data) {
                    $('#preview').html(data);
                }
            });
        })
        $(document).ready(function() {



            setTimeout(function() {
                $(".alert-danger").slideUp(500);
                $(".alert-success").slideUp(500);
            }, 2000);

            $(".edit_form").click(function() {
                id = $(this).val();
                $.ajax({
                    type: 'get',
                    data: {
                        id: id
                    },
                    url: "{{ route('model.model_index') }}",
                    success: function(data) {


                        $("#categoryID").val(data.data.categoryID);
                        $("#brandID").val(data.data.brandID);
                        $("#productName").val(data.data.productName);
                        $("#description").val(data.data.description);

                        $(".card-title").html('Edit Model').css('color', 'red');
                        $("#id").val(data.data.id);
                        $("#categoryID").focus();

                        scrollToTop();
                    }
                });
            });



            // $(".delete_modal").click(function() {
            $(document).on('click','.delete_modal',function(){
                id = $(this).attr('data');
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
                    url: "{{ route('qrcode.delete') }}",
                    success: function(data) {
                        $("#delete_modal").modal('hide');
                        document.location.reload();
                    }
                });
            });

            $("#categoryID").on('change', function() {
                var id = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "{{ route('model.getproduct') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    datatype: "json",
                    success: function(data) {
                        $('#brandID').empty();

                        $.each(data.data, function(key, value) {
                            $('#brandID')
                                .append($("<option></option>")
                                    .attr("value", value.brandid + "|" + value.modelid)
                                    .text(value.brand_name + '-' + value.productName));
                        });
                    }
                });
            });

            $('#datatable').DataTable({
                "ordering": false
            });

        });
    </script>
@endsection
