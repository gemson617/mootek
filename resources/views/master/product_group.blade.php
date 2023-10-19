@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                            <h5 class="card-header">Product Group</h5>
                       

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('products.addProductGroup')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                {{-- <input type="hidden" id='id' name='id'>
                                <input type="hidden" name="table" value="enquiry_sub_category" /> --}}
                                <div class="row">
                                        
                                    <div class="col-md-6">
                                        <label for="">Product group name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='product_group_name' class="form-control txt-num @error('product_group_name') is-invalid @enderror" name="product_group_name" placeholder="Product Group Name" />
                                            @error('product_group_name')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Product Price<span class="error">*</span></label>
                                        
                                        <div class="form-group">
                                            <input type="Text" id='product_price' class="form-control txt-num @error('product_price') is-invalid @enderror" name="product_price" placeholder="Product Price" />

                                            @error('product_price')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>


            </div>





            <div class="row mt-3" >
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Add Product Group</h5>


                    <div class="card-body">
               

                            <div class="row" id="purform">
                                <div class="max rtl-bc">
                                    <div class="multi-fields">
                                        <div class="multi-field " style="margin: 15px;">
                                            <div class="row" id="add_cal">
                                               
                                                <div class="col-md-3">
                                                    <label for="">Product type<span class="error">*</span></label>
                                                    <div class="form-group">
                                                        <select  id='product_type0' onchange="getproductstock(this.value,0)" data-id="0" class="form-select txt-num  @error('product_type') is-invalid @enderror"  name="product_type[]" >
                                                           <option value="">--Select--</option>
                                                           <option value="local" data-id='0'>Local</option>
                                                           <option value="import" data-id='0'>Import</option>
                                                    </select>
                                                        @error('product_type')
                                                    <div class="error">*{{$message}}</div>
                                                    @enderror
                                                    </div>
                                                </div>                                 
                                                 <div class="col-md-4">
                                                    <label for="">Product Name<span class="error"> * </span><a class="fa fa-plus-circle" href="/products_master"></a></label>
                                                    <div class="form-group">
                                                        <select  id='product_name0' onchange="getModelNumber(this.value,0)" class="product_change form-select txt-num  @error('product_name') is-invalid @enderror"  name="product_name[]" >
                                                           <option value="" data-id='0' data-name="">--Select--</option>


                                                    </select>
                                                        @error('product_type')
                                                    <div class="error">*{{$message}}</div>
                                                    @enderror
                                                    </div>
                                                </div> 

                                                <div class="col-md-4">
                                                    <label for="">Model No<span class="error">*</span></label>
                                                    <div class="form-group">
                                                        <input type="text" id="model_no0" name="model_no[]" data-id='0' data-name="" placeholder="Model No" class="product_change form-control txt-num  @error('model_no') is-invalid @enderror">
                                                      
                                                        @error('model_no')
                                                    <div class="error">*{{$message}}</div>
                                                    @enderror
                                                    </div>
                                                </div> 
                               
                               
                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4" id="adremovebuttons"><br/>
                                        <button type="button" id="button1"
                                            class="add-field btn btn-info btn-circle"><i class="fa fa-plus-circle"
                                            aria-hidden="true"></i></button>&nbsp;&nbsp;
                                    </div>
                                </div>

                               
                            </div>
                            <div class="row mt-3 ml-2">
                                <div class="col-md-6">
                                    <a href="/master-menus"  class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                    <a href="#"   class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                </div>
                            </div>
                    </div>


                </div>

            </div>

        </div>
    </form>

        <div class="row pb-5">
            <table id="datatable" class='table table-striped'>
                <thead>
                    <tr>
                        <th>Product Group Name</th> 
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $val)
                    <tr>
                        <td><?= $val->product_group_name ?></td>
                        <td><?= $val->price ?></td>
                        <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                        <td><a href="javascript:void(0)" data="<?= $val->id ?>" class="btn btn-primary edit_form"><i class="fa fa-edit"></i></a>
                        <button value='{{$val->id}}' data="{{$val->status}}" data-name="productGroup" class='btn btn-info change'>status</button>

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
<script>
        $('form[id="form"]').validate({

        rules: {
        product_group_name: 'required',
        product_price: 'required',
        'product_type[]':'required',
        'product_name[]': 'required',
        'model_no[]': 'required',
        },
        messages: {
        product_group_name: 'This Product Group Name is Required',
        product_price: 'This Product Price is Required',
        'product_type[]':'This Product Type is required',
        'product_name[]': 'This Product Name is required',
        'model_no[]': 'This Model Number is required',
        },
        errorPlacement: function(label, element) {
        label.addClass('mt-2 text-danger');
        if(element.hasClass('form-select') && element.next('.select2-container').length) {
        label.insertAfter(element.next('.select2-container'));
        }
        else{
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

        




                $('form[id="form"]').validate({
        rules: {
            category_name: 'required',
            active: 'required',
        },
        messages: {
            category_name: 'This category name  is required',
            active: 'This Status is required',
        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            if(element.hasClass('form-select') && element.next('.select2-container').length) {
            label.insertAfter(element.next('.select2-container'));
            }
            else{
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
    $(document).ready(function() {
        
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);






        // $('#datatable').DataTable({
        //     "ordering": false
        // });
        
        

        
       
    });


    $(document).ready(function(){




    $('.max').each(function() {
                    var $wrapper = $('.multi-fields', this);

                    //$(".selectDrop").each(function(){
                      //  $(".selectDrop").select2('destroy');
                  //  })

                    $(".add-field", $(this)).click(function(e, count) {
                       
                        var count = $('.multi-field').length;
                        // alert(count);

                            // getCategory(count);
                            // $('#categoryID'+count).select2('destroy');
                            var row = $(
                            '<div class="multi-fields rtl-bc '+count+'" id="multi"> <div class="multi-field multi-field'+count+'"> <div class="row multidiv'+count+'" id="add_cal" style="; padding: 18px;">' +
                            '<div class="col-md-3"><label for="">Product type<span class="error">*</span></label><div class="form-group product_change"><select id="product_type' +
                            count + '"name="product_type[]" onchange="getproductstock(this.value,'+count+')" class="form-select selectDrop product "><option value=""> --Select--</option><option value="local" data-id="'+count+'">local</option><option value="import" data-id="'+count+'">Import</option>  </select> </div></div>' +
                           '<div class="col-md-4"><label for="">Product Name<span class="error">*</span><a class="fa fa-plus-circle" href="/products_master"></a></label><div class="form-group "><select id="product_name' +
                            count + '"name="product_name[]" onchange="getModelNumber(this.value, ' + count + ')" class="form-select selectDrop product product_change"><option value=""> --Select--</option></select><p class="error" id="model_error'+count+'"></p></div></div>' +
                            '<div class="col-md-4 serialcol"><label for="">Model No<span class="error">*</span></label><div class="form-group "><input type="text" id="model_no'+count+'" name="model_no[]" data-id="'+count+'"  placeholder="Model Number" class="product_change form-control txt-num"><p class="error" id="serial_error'+count+'"></p></div></div>' +
                       
                            '<div class="col-md-1 mt-5" style="width: 3.333333%"><i class="fa fa-trash" onclick="removediv('+count+')" id="remove'+count+'" style="font-size:22px;color:red"></i></div></div></div></div>');
                            row.appendTo($wrapper);
                            $('select').select2();
                            $(".product_change").on("change", function() {
          
                        // Get the selected option
                        var selectedOption = $(this).find("option:selected");
                        
                        var dataid = selectedOption.data("id");
                       
                        var dataname = selectedOption.data("name");
                   
                        
                        var inputValue =  selectedOption.val();
                        // alert (inputValue);
                        });
                       
                            });
                            
                           

                        });  
                        
});

$(".edit_form").click(function() {
            id = $(this).attr('data');
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('edit.group_products')}}",
                success: function(data) {
                    console.log(data.data);
                    $("#product_group_name").val(data.master.product_group_name);
                    $("#product_price").val(data.master.price);
                    // The number of rows you want to add
                    var numberOfRows = data.data.length; // Change this to the desired number of rows
                    // The container element where you want to append the rows
                    $(".multi-fields").empty();
                    var container = $(".multi-fields");
                    for (var i = 0; i < numberOfRows; i++) {
    // Create a new row
    var row = $(
        '<div class="multi-fields rtl-bc ' + i + '" id="multi">' +
        '    <div class="multi-field multi-field' + i + '">' +
        '        <div class="row multidiv' + i + '" id="add_cal" style="padding: 18px;">' +
        '            <div class="col-md-3">' +
        '                <label for="">Product type<span class="error">*</span></label>' +
        '                <div class="form-group product_change">' +
        '                    <select id="product_type' + i + '" name="product_type[]" onchange="getproductstock(this.value, ' + i + ')" class="form-select selectDrop product ">' +
        '                        <option value="">--Select--</option>' +
        '                        <option value="local" ' + (data.data[i].product_type == 'local' ? 'selected' : '') + '>local</option>' +
        '                        <option value="import" ' + (data.data[i].product_type == 'import' ? 'selected' : '') + '>Import</option>' +
        '                    </select>' +
        '                </div>' +
        '            </div>' +
        '            <div class="col-md-4">' +
        '                <label for="">Product Name<span class="error">*</span></label>' +
        '                <div class="form-group">' +
        '                    <select id="product_name' + i + '" name="product_name[]" onchange="getModelNumber(this.value, ' + i + ')" class="form-select selectDrop product product_change">' +
                                '<option value="'+data.data[i].product_id+'">'+data.data[i].product_name+'</option>' +
        '                    </select>' +
        '                    <p class="error" id="model_error' + i + '"></p>' +
        '                </div>' +
        '            </div>' +
        '            <div class="col-md-4 serialcol">' +
        '                <label for="">Model No<span class="error">*</span></label>' +
        '                <div class="form-group">' +
                      '<input type="text" id="model_no' + i + '" class="form-control"  value="'+data.data[i].model_no+'" placeholder="Model No" name="model_no[]" />' +

        '                    <p class="error" id="serial_error' + i + '"></p>' +
        '                </div>' +
        '            </div>' +
        '            <div class="col-md-1 mt-5" style="width: 3.333333%">' +
        '                <i class="fa fa-trash" onclick="removediv(' + i + ')" id="remove' + i + '" style="font-size: 22px; color: red"></i>' +
        '            </div>' +
        '        </div>' +
        '    </div>' +
        '</div>'
    );

    // Append the new row to the container
    container.append(row);
    $('.selectDrop').select2();
}

                    $(".card-title").html('Edit Customer').css('color', 'red');
                    $("#id").val(data.master.id);
                    $(".cat").focus();
                    
                    scrollToTop();
                }
            });
        });
        
        function removediv(no){
            $('.multi-field'+no).remove();
            // var id = $('#id'+no).val();
            // var $wrapper = $('#removefield');
            // var row = $('<input type="hidden" id="removeid" name="removeid[]" value="'+id+'">');
            // row.appendTo($wrapper);
            // calculateAmount();
        } 
        function getproductstock(val, no) {
            $.ajax({
                url: '{{route("get.products")}}',
                type: 'POST',
                data: {
                    id: val,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    $('body').css('cursor', 'progress');
                },
                success: function(data) {
                   $("#product_name"+no).empty();
                    var select = $('#product_name'+no); // Get a reference to the select element
                    // Loop through the data array and create options
                    select.append($('<option>', {
                    value: "", // Set the value attribute to an empty string or any value you prefer
                    text: "--select--"  // Set the text content of the option
                    }));
                    $.each(data.data, function(index, item) {
                        console.log(item);
                    var option = $('<option>', {
                    value: item.id, // Set the value attribute
                    text: item.product_name  // Set the text content of the option
                    });
                    select.append(option); // Append the option to the select element
                    });
                },
                async: false
            });
        }
        function getModelNumber(val, no) {
            $.ajax({
                url: '{{route("get.products")}}',
                type: 'POST',
                data: {
                    model: val,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    $('body').css('cursor', 'progress');
                },
                success: function(data) {
                    $('#model_no'+no).val(data.data.model_number)
                },
                async: false
            });
        }


</script>
@endsection