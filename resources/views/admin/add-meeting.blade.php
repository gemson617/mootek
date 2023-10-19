@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="page-header">
            <div class="page-leftheader">
                <h4 class="page-title">Add Meeting</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.meeting')}}">Meeting</a></li>
                    <li class="breadcrumb-item"><a href="#">Add Meeting</a></li>
                </ol>
            </div>
        </div>

        <form action="{{ route('admin.store-meeting') }}" method="post" id="customerFormData" enctype="multipart/form-data">
            @csrf
            <fieldset class="form-group border p-3">
                <legend class="w-auto px-2">Meeting</legend>
                <div class="row my-2">
                    <div class="form-group col-sm-4">
                        <label>Meeting Date<span class="error">*</span></label>
                        <input type="date"                           
                            name="meeting_date" id="meeting_date" value="" class="form-control click-date">                      
                        @error('meeting_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-sm-4">
                        <label>Start Time<span class="error">*</span></label>
                        <input type="text"                           
                            name="start_time" id="start_time" value="" class="form-control  ">
                        @error('start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <label>End Time<span class="error">*</span></label>
                        <input type="text"                           
                            name="end_time" id="end_time" value="" class="form-control ">
                        @error('end_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Invite List:</label>
                        <select type="text" multiple name="users[]" id='invite_list' class="form-control select2">
                            <option value="">--Select--</option>  
                            <?php foreach($users as $row){ ?>
                                <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                    <div class="form-group col-sm-4">
                        <label>Meeting Agenda:</label>
                        <textarea class="form-control" name="agenda"></textarea>
                    </div> 
                    <div class="form-group col-sm-4">
                        <label>Meeting Link(URL): </label>
                        <input type="text" name="meeting_link" id='meeting_link'
                            class="form-control" value="{{ old('meeting_link') }}">
                    </div>  
                    <div class="form-group col-sm-4">
                        <label>Location: </label>
                        <input type="text" name="location" id='location'
                            class="form-control" value="{{ old('location') }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Reminder:</label>
                        <select type="text" name="reminder" id='reminder' class="form-control">
                            <option value="">--Select--</option>
                            <option value="15">15 Minutes</option>
                            <option value="30">30 Minutes</option>                            
                        </select>
                    </div>                
                </div>
                <div class="form-group pull-right">
                    <input type="submit" class="btn btn-info" value="Add Meeting" />
                </div>
                
            </fieldset>


            <br>
        </form>

    </div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
      $(document).ready(function() {
    $('#invite_list').select2();
});

$('#start_time, #end_time').timepicker({
    showMeridian: false,
    icons:{
        up: 'fa fa-angle-up',
        down: 'fa fa-angle-down'
    }
});
function checkExists(val, error_cls, column, table, label) {

    $.ajax({
        type: "GET",
        url: '{{route("customer.check-exist")}}',
        data: {
            'column': column,
            'table': table,
            'field': val
        },
        success: function(data) {
            if (data === '0') {
                $('.' + error_cls).hide();
                $('.' + error_cls).removeClass('text-info');
            } else {
                $('.' + error_cls).text("This " + label + " Already Exist");
                $('.' + error_cls).show();
                $('.' + error_cls).addClass('text-info');
            }
        }
    });
}

function get_id(e) {
    var id = $(e).data('row') + 1;
    console.log(id);
    if (id != 0) {
        $('#category' + id).parent().parent().remove();
    }
}

$('#idproducttype').change(function() {
    var test = $('#idproducttype').val();
    var custid = $('#customer_id').val();
    var url = "<?php echo url('/customer-loadcategory/');?>/" + test + "/" + custid;
    $.ajax({
        type: 'GET',
        url: url,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            // alert(JSON.stringify(data))
            $('#pro_type11').html('');
            $('#productappend').html(
                '<select class="form-control" onchange="jsFunction(this.value);" id="pro_type11" name="product_id"> <option value="">-Selected Product-</option></select>'
                );
            for (var i = 0; i < data.length; i++) {
                $('#pro_type11').append('<option value="' + data[i].id + '">' + data[i].name +
                    '</option> ');
            }

        },
        error: function(data) {
            console.log(data);
        }
    });
});

function company(value) {
    var x;
    x = value;
    document.getElementById('trading_as').value = x;

}

function send_to_other() {
    var value = $('#send_docket_to').val();
    if (value == 4) {
        // alert("oog");
        $("#other_email").show();
    } else {
        $("#other_email").hide();
    }

}

function usage_type_cook() {
    var value_c = $('#cooking').val();
    if (value_c == "cooking") {
        $("#dont_know").prop('checked', false);
    }
}

function usage_type_hot() {
    var value_hw = $('#hot_water').val();
    if (value_hw == "hot water") {
        $("#dont_know").prop('checked', false);
    }
}

function usage_type_heat() {
    var value_h = $('#heating').val();
    if (value_h == "heating") {
        $("#dont_know").prop('checked', false);
    }
}

function usage_type_dontknow() {
    var value = $('#dont_know').val();
    if (value == "Don't know") {
        $("#heating").prop('checked', false);
        $("#hot_water").prop('checked', false);
        $("#cooking").prop('checked', false);
    }
}

function get_suburb(val, post, sb) {
    $('#' + post).val('');
    if (val.length > 0) {
        var sub = $('#' + sb + ' option:selected').text().split(" ");
        (sub[2] == null || sub[2] == '') ? $('#' + post).val(sub[1]): $('#' + post).val(sub[2]);
    }

}


function addRow(content_id, label_checkbox = '') {
    var ac_type = $('#account_type').val();
    //alert(ac_type);
    var row = $("#" + content_id + " tr:last");
    row.clone().find("input, textarea, select, button, checkbox, radio, label").each(function(j, obj) {

        i = $(this).data('row') + 1;
        id = $(this).data('name') + i;
        label_for = $(this).data('name') + i;
        //$(this).val('').attr({'id' : id, 'data-row' : i, 'for' : label_for});
        $(this).val(obj.value).attr({
            'id': id,
            'data-row': i,
            'for': label_for
        });
        if (ac_type == 1) {
            //alert("1");
            $('#rental_period0').val(6);
            $('#rental_period1').val(6);
            $('#rental_period2').val(6);
            $('#rental_period3').val(6);
            $('#rental_period4').val(6);
            $('#rental_period5').val(6);
            $('#rental_period6').val(6);
            $('#rental_period7').val(6);
            $('#rental_period8').val(6);
            $('#rental_period9').val(6);
            $('#rental_period10').val(6);
        }
        if (ac_type == 2) {
            //alert("2");
            $('#rental_period0').val(3);
            $('#rental_period1').val(3);
            $('#rental_period2').val(3);
            $('#rental_period3').val(3);
            $('#rental_period4').val(3);
            $('#rental_period5').val(3);
            $('#rental_period6').val(3);
            $('#rental_period7').val(3);
            $('#rental_period8').val(3);
            $('#rental_period9').val(3);
            $('#rental_period10').val(3);
        }
        // $(this).val(obj.value);
        $('#cost_price' + i).val('');
        $('#actual_price' + i).val('');
        // console.log(obj.find('rental_period'+i));
    }).end().appendTo("#" + content_id);
}

$('.pros').on('change', function() {

})

function get_price(value) {
    var id = value.dataset.row;
    var pro = $('#product_id' + id).val();
    var ac_type = $('#account_type').val();
    //alert(ac_type);
    var url = "<?php echo url('/customer-getprice/');?>/" + pro;
    $('#actual_price' + id).val('');
    $('#cost_price' + id).val('');
    $('#actual_price_res' + id).val('');
    $('#cost_price_res' + id).val('');
    $('#rental_price' + id).val('');
    $('#rental_price_res' + id).val('');
    $.ajax({
        type: 'GET',
        url: url,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            $('#actual_price' + id).val(data.rrp);
            $('#cost_price' + id).val(data.rrp);
            $('#rental_price' + id).val(data.monthly_price);


            var pt = parseFloat(data.rrp) + parseFloat(data.rrp * 0.1);
            ingst = parseFloat(pt).toFixed(2);
            $('#actual_price_res' + id).val(ingst);
            $('#cost_price_res' + id).val(ingst);
            var rent = parseFloat(data.yearly_price) + parseFloat(data.yearly_price * 0.1);
            inrent = parseFloat(rent).toFixed(2);
            $('#rental_price_res' + id).val(inrent);
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function codTerms(val) {
    if (val == 7) {
        $('#credit_limit').val(0);
        $("#credit_limit").attr('disabled', true);
    } else {
        $("#credit_limit").attr('disabled', false);
    }
}

function get_rental(value) {

    //console.log(value);

    var custype = $('#account_type').val();
    //alert(custype);
    var id = value.dataset.row;
    var pro = $('#product_id' + id).val();
    var rent = $('#rental_period' + id).val();
    if (rent == 0) {
        $('#comm_rent_price').hide();
        $('#res_rent_price').hide();
        $('#no_rent_reason').show();
    } else {
        if (custype == 1) {
            $('#comm_rent_price').hide();
            $('#res_rent_price').show();
            $('#no_rent_reason').hide();
        }
        if (custype == 2) {
            $('#comm_rent_price').show();
            $('#res_rent_price').hide();
            $('#no_rent_reason').hide();
        }

        var url = "<?php echo url('/customer-getrent/');?>/" + pro + "/" + rent;
        $.ajax({
            type: 'GET',
            url: url,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                $('#rental_price' + id).val(data);
                var rt = parseFloat(data) + parseFloat(data * 0.1);
                inrst = parseFloat(rt).toFixed(2);
                $('#rental_price_res' + id).val(inrst);

            },
            error: function(data) {
                console.log(data);
            }
        });
    }

}



function get_product(value) {
    var id = value.dataset.row;
    // var pro=$('#product_id'+id).val();
    var cate = $('#category' + id).val();
    var url = "<?php echo url('/customer-loadproduct/');?>/" + cate;
    $.ajax({
        type: 'GET',
        url: url,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            $('#product_id' + id).html('');
            var html = "<option value=''>Select Product</option>";
            if (data.length > 0) {

                // var rows=JSON.parse(data);
                // console.log(rows);
                for (var i = 0; i < data.length; i++) {
                    html += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                $('#product_id' + id).html(html);
            }

            // $('#actual_price'+id).val(data.cost_price);
            // $('#rental_price'+id).val(data.outright_price);

        },
        error: function(data) {
            console.log(data);
        }
    });

}

function Same_day() {
    var s_day = $('#same_day').val();
    var myDate = new Date();
    myDate.setDate(myDate.getDate());

    var dt = myDate.getDate() + '-' + ("0" + (myDate.getMonth() + 1)).slice(-2) + '-' + myDate.getFullYear();
    // alert(s_day);
    if (s_day == '1') {
        $('#few_days').hide();
        $("#datepicker").val(dt);
    } else {
        $('#few_days').show();
        $("#datepicker").val('');
    }
}

function searchStreetName(val, id, div, ob, e) {
    if (e.keyCode != 9 && e.keyCode != 16) {
        if ($(ob).val().length < 2) {
            return;
        }
        $.ajax({
            type: "GET",
            url: '{{route("customer.street-search")}}',
            data: {
                'streetname': val,
                'id': id
            },
            success: function(data) {
                $('#' + div).html('');
                //alert(data);
                if (data) {
                    $('#' + div).html(data);
                    $('#' + div).show();
                }
            }
        });
    }
}

function setStreetName(id, val, name, e) {
    $(e).parent().hide();
    $('#' + name).val(val);
}


function postcodeSearch(suburb, post_code, div, ob, e) {
    if (e.keyCode != 9 && e.keyCode != 16) {
        if ($(ob).val().length < 3) {
            return;
        }
        postcode_val = $('#' + post_code).val();
        suburb_val = $('#' + suburb).val();
        $.ajax({
            type: "GET",
            url: '{{route("customer.customer-loadpostcode")}}',
            data: {
                'srch_post_code': postcode_val,
                'srch_suburb': suburb_val
            },
            success: function(data) {
                $('#' + div).html('');
                //alert(data);
                if (data) {
                    $('#' + div).html(data);
                    $('#' + div).show();
                }
            }
        });
    }
}

function promoCodeSearch(promocode, div, ob, e) {
    if (e.keyCode != 9 && e.keyCode != 16) {
        if ($(ob).val().length < 3) {
            return;
        }
        promoCode_val = $('#promo_code').val();
        $.ajax({
            type: "GET",
            url: '{{route("customer.promo-code-search")}}',
            data: {
                'promo_code': promoCode_val
            },
            success: function(data) {
                $('#' + div).html('');
                //alert(data);
                if (data) {
                    $('#' + div).html(data);
                    $('#' + div).show();
                }
            }
        });
    }
}


function setPostCode(id, post_code, name, state, e) {
    $('#' + jQuery(e).parent().attr('data-suburb')).val(name);
    $('#' + jQuery(e).parent().attr('data-postcode')).val(post_code);
    $(e).parent().hide();
    $('#' + jQuery(e).parent().attr('data-subid')).val(id);
}

function setPromoCode(id, promo_code) {
    // alert(id); alert(promo_code);
    $('#promo_code').val(promo_code);
    $('#promo_id').val(id);
    $('#promoSearch').hide();

}


function validateEmail1(value) {

    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {

        return (true);

    }
    alert("You have entered an invalid email address!")
    return (false)

}
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    var date = $('#datepicker').datepicker({
        dateFormat: 'dd-mm-yy'
    }).val();
    $("#datepicker").val(date);
});
</script>
@endsection