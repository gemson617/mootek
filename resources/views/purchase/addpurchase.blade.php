@extends('layouts.app')

@section('content')

<style>
    #brandID-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }

    #categoryID-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }

    #supplierID-error {
        position: absolute !important;
        top: 69px !important;
        left: 21px !important;
    }
</style>
    <div class="content-wrapper">
        <div id="snackbar"></div>
        <div class="content container">
            <!--START PAGE HEADER -->
            <header class="page-header">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                    </div>
                    <ul class="actions top-right">
                        <li class="dropdown">
                            <!-- <a href="product.php" class="btn "  aria-expanded="false">

             View Product List<i class="la la-eye"></i>

            </a> -->

                        </li>
                    </ul>
                </div>
            </header>
            <section class="page-content" id="form">
            <form id="purchase" method="post" action="{{ route('add.purchase') }}">
                                    @csrf
                                <div class="card">
                                <h7 class="card-header">Purchase</h7>
                                <div class="card-body  p-4">
                                    @if (session('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('msg') }}
                                    </div>
                                @endif
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Select Local Purchase Bill<span class="error">*</span> <a class="fa fa-plus-circle" href="/purchase-view"></a></label>
                                            <select class="form-select @error('supplierID') local_purchase is-invalid @enderror"
                                                id="local_purchase" name="local_purchase">
                                                <option value="" >--Select--</option>
                                                @foreach ($local_purchase as $sdata)
                                                    <option value="{{ $sdata->id }}" data="{{$sdata->credit_tax}}" data-cess="{{$sdata->credit_cess}}">{{ $sdata->purchase_company }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('local_purchase')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-3 mb-3">

                                            <label for="validationCustomUsername">Purchase Date<span class="error">*</span></label>
                                            <input type="hidden" id="tax_amount_value" name="tax_amount_value">
                                            <input type="date"
                                                class="form-control datePickerInput @error('purchaseDate') is-invalid @enderror"
                                                name="purchaseDate"  id="purchaseDate" style="background-color: white"
                                                placeholder="yyyy/mm/dd">
                                            @error('purchaseDate')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Select Purchase Executive <span class="error">* </span><a class="fa fa-plus-circle" href="/employee"></a></label>
                                            <select class="form-select @error('purchase_executive') purchase_executive is-invalid @enderror"
                                                id="purchase_executive" name="purchase_executive">
                                                <option value="" >--Select--</option>
                                                @foreach ($purchase_executive as $sdata)
                                                    <option value="{{ $sdata->id }}">{{ $sdata->first_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('purchase_executive')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Select Purchase For <span class="error"> *</span><a class="fa fa-plus-circle" href="/role_master"></a></label>
                                            <select class="form-select @error('purchase_role') purchase_role is-invalid @enderror"
                                                id="purchase_role" name="purchase_role">
                                                <option value="" >--Select--</option>
                                                @foreach ($purchase_role as $sdata)
                                                    <option value="{{ $sdata->id }}">{{ $sdata->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('purchase_role')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-md-3 mb-3">
                                            <label for="validationCustomUsername">Select Tax<span class="error">*</span></label>
                                            <select class="form-select @error('tax_amount_value') tax_amount_value is-invalid @enderror"
                                                id="tax_amount_value" name="tax_amount_value">
                                                <option value="" >--Select--</option>
                                                @foreach ($tax as $sdata)
                                                    <option value="{{ $sdata->name }}">{{ $sdata->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tax_amount_value')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div> --}}
                                        {{-- <div class="col-md-3 mb-3 p-3">
                                        <input class="purchasetype" type="radio" checked value="1" name="purchasetype" id="sp">
                                            <label for="validationCustomUsername">Normal</label> &nbsp;
                                        <input class="purchasetype" type="radio" value="2" name="purchasetype" id="mp">
                                            <label for="validationCustomUsername">Bulk</label>
                                        </div> --}}
                                        </div>
                                    </div>
                                </div>


                <div class="row" >
                    <div class="col-md-12">
                        <div class="card">
                            <h5 class="card-header">Add Local Purchase</h5>


                            <div class="card-body">
                       

                                    <div class="row" id="purform">
                                        <div class="max rtl-bc">
                                            <div class="multi-fields">
                                                <div class="multi-field " style="margin: 15px;">
                                                    <div class="row" id="add_cal">
                                                        <input type="hidden" id='id' name='id'>
                                        <div class="col-md-2 mb-3" id="loadData">
                                            <label for="validationCustom01">Select Product <span class="error"> * </span><a class="fa fa-plus-circle" href="/products_master"></a></label><br>
                                            <div class="form-group">
                                                <select id='product0'
                                                    class="product_change form-select @error('product') is-invalid @enderror"
                                                    value="" name="product[]">
                                                    <option value=""> --Select--</option>
                                                    @foreach ($product as $val)
                                                    <option value="{{$val->id}}" data-id='0' data-name="{{$val->model_number}}">{{$val->product_name}}</option>
                                                    @endforeach
                                                </select>
                                                <p id="brand0" class="error"></p>
                                                @error('product.*')
                                                    <div class="error">*{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustomUsername">Model No<span class="error">*</span></label>
                                            <input type="text"
                                                class="form-control"
                                                id="model0" name="model[]" placeholder="Model Number">
                                                <p  class="error" id="serial_error0"></p>
                                            @error('serial.*')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 mb-3 serialcol"  id="serialcol">
                                            <label for="validationCustomUsername">Serial No <span class="error">*</span></label>
                                            <input type="text"
                                                class="form-control  @error('serial') is-invalid @enderror serial"
                                                id="serial0" name="serial[]" placeholder="Enter Serial Number">
                                                <p  class="error" id="serial_error0"></p>
                                            @error('serial.*')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-1 mb-3 qtycol"  id="qtycol">
                                            <label for="validationCustomUsername">Qty<span class="error">*</span></label>
                                            <input type="text"
                                                class="form-control  @error('qty') is-invalid @enderror qty" oninput="getprice(0)"
                                                id="qty0" name="qty[]" placeholder="Qty" readonly>
                                                <p  class="error" id="qty_error0"></p>
                                            @error('qty.*')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustomUsername">Rate<span class="error">*</span></label>
                                            <input type="number" step="any"
                                                class="form-control   @error('rate') is-invalid @enderror"
                                                id="rate0" name="rate[]"
                                                placeholder="Enter Rate Price" oninput="getprice(0)">
                                                <p id="pur_price0" class="error"></p>
                                            @error('pur_price.*')
                                                <div class="error">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="validationCustomUsername">Amount<span class="error">*</span></label>
                                            <input type="number" step="any"
                                                class="form-control   @error('amount') is-invalid @enderror totalamount"
                                                id="amount0" name="amount[]" 
                                                placeholder="Enter Amount" readonly>
                                                <p id="sell_p0" class="error"></p>
                                            @error('amount.*')
                                                <div class="error" >*{{ $message }}</div>
                                            @enderror
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

                                        <!-- <div class="col-md-3 mb-3"><br>
                                            <button class="btn btn-primary" id="add_roduct">Save</button>
                                        </div> -->
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12  d-flex justify-content-end">
                                            <table class="table table-bordered text-right">
                                                <tr>
                                                    <td class="w-75">Taxable Price</td>
                                                    <td>
                                                        <input type="Text" id='tax_price' value="" class="form-control txt-num @error('tax_price') is-invalid @enderror" name="tax_price" readonly />
                    
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Others Charges(+)</td>
                                                    <td>
                                                        <input type="number" id='others' value='0'  class="form-control txt-num @error('others') is-invalid @enderror" name="others" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>CESS(+)</td>
                                                    <td>
                                                        <input type="number" id='cess' value='0' oninput="cess()" class="form-control txt-num @error('cess') is-invalid @enderror" name="cess" readonly/>
                                                    </td>
                                                </tr>
                                                <tr id="gst_list">
                                                    <td id="tax_amount">Tax Amount(%)</td>
                                                    <td>
                                                        <input type="number" id='tax_percent' value='0' class="form-control  @error('tax_percent') is-invalid @enderror " name="tax_percent" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Grand Total</td>
                                                    <td>
                                                        <input type="Text" id='grand_total'  class="form-control txt-num @error('grand_total') is-invalid @enderror" name="grand_total" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                    
                                        <div class="col-md-2 mt-2">
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-sm btn-success mr-1">Add Purchase Bill</button>
                                            </div>
                    
                                        </div>
                                    </div>
                            </div>


                        </div>

                    </div>

                </div>

                </form>
            </section>

        </div>
        <script>
     
            
                    function commoncalc(){
                      var  totalamount=0;
                      console.log(totalamount);
               $(".totalamount").each(function(j, ob) {
                if ($.isNumeric(ob.value)) {
                    totalamount += parseFloat(ob.value);
                }
            });
            $("#tax_price").val(totalamount);
            others=$("#others").val() ?$("#others").val():0;
            cess=$("#cess").val()?$("#cess").val():0;
            tax_amount=$("#tax_amount_value").val();
             if(tax_amount !=''){
                  total=(parseInt(totalamount)+parseInt(others)+parseInt(cess))*tax_amount/100;
                  $("#tax_percent").val(total);
                  $("#grand_total").val(parseInt(total)+(parseInt(totalamount)+parseInt(others)+parseInt(cess)));
             }
             
            
        }
        $('#others').on('input', function(e) {
            commoncalc();
        });
        $('#cess').on('input', function(e) {
            commoncalc();
        });
        
    $(".product_change").on("change", function() {
            // Get the selected option
            var selectedOption = $(this).find("option:selected");
            
            // Get the value of the 'data-value' attribute of the selected option
            var dataid = selectedOption.data("id");
            var dataname = selectedOption.data("name");
            $("#model"+dataid).val(dataname);
            $("#qty"+dataid).val(1);
        });
        $("#local_purchase").on("change", function() {

            commoncalc();
            // Get the selected optioncess
            var selectedOption = $(this).find("option:selected");
            var tax = selectedOption.attr('data');
            var cess = selectedOption.data('cess');
            $("#tax_amount_value").val(tax);
            $("#cess").val(cess);
            $("#tax_amount").html("Tax Amount(" + tax + "%)");
            // Get the value of the 'data-value' attribute of the selected option
        });
        
        $('form[id="purchase"]').validate({

rules: {
    local_purchase: 'required',
invoice_no: 'required',
purchaseDate: 'required',
purchase_executive: 'required',
purchase_role: 'required',
tax_amount_value: 'required',
'product[]':'required',
'model[]': 'required',
'serial[]': 'required',
'rate[]': 'required',

'qty[]': 'required',
'amount[]': 'required',
},
messages: {
    local_purchase: 'This Local Purchase is Required',
invoice_no: 'This invoice No is Required',
purchaseDate: 'This Purchase Date is Required',
tax_amount_value: 'This Tax is Required',

purchase_executive: 'This Purchase Executive is Required',
purchase_role: 'This Purchase For is Required',
'product[]':'This Product is required',
'model[]': 'This Model is required',
'serial[]': 'This Serial is required',
'qty[]': 'This is Qty is required',
'rate[]': 'This is Rate is required',


'amount[]': 'This is  Amount required',
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


 $(".purchasetype").click(function(){
    value=$(this).val();
    producttype(value);
 });
  
 function producttype(value){
    if(value =='1'){
      $(".qtycol").addClass('d-none');
      $(".serialcol").removeClass('d-none');
    }else{
        $(".serialcol").addClass('d-none');
        $(".qtycol").removeClass('d-none');
    }
 }


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
                            '<div class="multi-fields rtl-bc '+count+'" id="multi"> <div class="multi-field"> <div class="row multidiv'+count+'" id="add_cal" style="; padding: 18px;">' +
                            '<div class="col-md-2"><label for="">Select Product<span class="error">*</span></label><div class="form-group "><select id="product' +
                            count + '"name="product[]" class="form-select selectDrop product product_change"><option value=""> --Select--</option>@foreach ($product as $val)<option value="{{$val->id}}" data-id="'+count+'" data-name={{$val->model_number}}>{{$val->product_name}}</option>@endforeach</select> </div></div>' +
                           '<div class="col-md-2"><label for="">Model No<span class="error">*</span></label><div class="form-group "><input type="text" id="model' +
                            count + '" name="model[]" class="form-control model"  placeholder="Enter model Number"/><p class="error" id="model_error'+count+'"></p></div></div>' +
                            '<div class="col-md-2 serialcol"><label for="">Serial No<span class="error">*</span></label><div class="form-group "><input type="text" id="serial' +
                            count + '" name="serial[]" class="form-control serial"  placeholder="Enter Serial Number"/><p class="error" id="serial_error'+count+'"></p></div></div>' +
                            '<div class="col-md-1 qtycol"><label for="">Qty<span class="error">*</span></label><div class="form-group "><input type="text" id="qty' +
                            count + '" name="qty[]" class="form-control qty"  placeholder="Qty" oninput="getprice('+count+'))" readonly/><p class="error" id="qty_error'+count+'"></p></div></div>' +
                            '<div class="col-md-2"><label for="">Rate<span class="error">*</span></label><div class="form-group"><input type="number" step="any" id="rate' +
                            count + '" name="rate[]" class="form-control" placeholder="Enter Rate Price" oninput="getprice('+count+')"/><p id="pur_price'+count+'" class="error"></p></div></div>' +
                            '<div class="col-md-2"><label for="">Amount<span class="error">*</span></label><div class="form-group"><input type="number" step="any" id="amount' +
                            count + '" name="amount[]" class="form-control totalamount"   placeholder="Enter Amount" readonly/></div><p id="sell_p'+count+'" class="error"></p><div class="error"> <p  id="sell_p'+count+'"></p></div></div>' +
                            '<div class="col-md-1 mt-5" style="width: 3.333333%"><i class="fa fa-trash" onclick="removediv('+count+')" id="remove'+count+'" style="font-size:22px;color:red"></i></div></div></div></div>');
                            row.appendTo($wrapper);
                            $(".selectDrop").select2();
                        $(".product_change").on("change", function() {
                        // Get the selected option
                        var selectedOption = $(this).find("option:selected");
                        // Get the value of the 'data-value' attribute of the selected option
                        var dataid = selectedOption.data("id");
                        var dataname = selectedOption.data("name");
                        $("#model"+dataid).val(dataname);
                         $("#qty"+dataid).val(1);

                        });
                        // productType = $('input[name="purchasetype"]:checked').val();
                        // producttype(productType);
                            });
                            
                            // SELLING PRICE VALIDATION

                        });  
                        
});

                        function removediv(no){
                // alert(no);
                $('.multidiv'+no).remove();
            }
        function getprice(no){
            qty =$("#qty"+no).val();
            rate =$("#rate"+no).val();
            if(qty == ''){
                qty=1;
            }
            amount=qty*rate;
            $("#amount"+no).val(amount);
            commoncalc();
        }

        </script>
    @endsection

