@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<div class="app-content page-body p-3">
    <div class="container">
        <div class="row justify-content-center">
        @include('layouts.partials.menu')
            <div class="col-md-12">
                <div class="row">
                    <h4 class="page-title col-6">Truck Maintenance Records - {{$trucks['make']}} {{$trucks['rego']}}</h4>
                    <div class="col-6">
                        {{-- <a href="/add-service-record" class=" btn btn-sm btn-primary pull-right" >Create Service Record</a> --}}
                    </div>

                </div>

                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Trucks & Dispatch</a></li>
                </ol>
            </div>
        </div>
    </div>
    @if(isset($add))
    <form    method="post" enctype="multipart/form-data" action="{{ route("admin.create_service") }}">
    @else
    <form    method="post" enctype="multipart/form-data" action="{{ route("admin.update_service") }}">
        <input type="hidden" value="{{$sid}}" id="service_id" name="service_id" />
    @endif
        @csrf
        <input type="hidden" value="{{$trucks['id']}}" id="truck_id" name="truck_id" />

    <div class="row" >
        <div class="col-6">
            <div class="card p-1">
                <div class="row">
                    <div class="form-group col-4" >
                        <label>Start Date: </label>
                        <input type="datetime-local" name="start_date" class="form-control click-date" value="{{isset($services['start_date']) ? date('d-m-Y h:m:s',strtotime($services['start_date'])):''}}">
                    </div>
                    <div class="form-group col-4">
                        <label>End Date: </label>
                        <input type="datetime-local" name="end_date" class="form-control click-date" value="{{isset($services['end_date']) ? date('d-m-Y h:m:s',strtotime($services['end_date'])):''}}">
                    </div>
                    <div class="form-group col-4">
                        <label>Vechicle: </label>
                        <input disabled type="text" name="vechicle" class="form-control click-date" value="{{$trucks['make']}} {{$trucks['rego']}}">
                    </div>

                    <div class="col-4 form-group">
                        <label>Phone: </label>
                        <input type="text" class="form-control" id="end_time" name="end_time" value="{{isset($services['phone']) ? $services['phone']:''}}"  required>
                    </div>

                    <div class="form-group col-4" >
                        <label>Email: </label>
                        <input type="text" name="email" class="form-control " value="{{isset($services['email']) ? $services['email']:''}}">
                    </div>
                    <div class="form-group col-4">
                        <label>Serviced By: </label>
                        <input type="text" name="serviced_by" class="form-control " value="{{isset($services['serviced_by']) ? $services['serviced_by']:''}}">
                    </div>
                    <div class="form-group col-4">
                        <label>Quoted Price: </label>
                        <input type="text" name="quoted_price" class="form-control " value="{{isset($services['quoted_price']) ? $services['quoted_price']:''}}">
                    </div>
                    <div class="col-4 form-group">
                        <label>Quote Accepted by: </label>
                        <option value="0">Select </option>
                        <select name="quote_acceptedby" class="form-select" value="">
                            @foreach ($users as $user)
                            @if(isset($services['quote_acceptedby']) && $services['quote_acceptedby']== $user['id'])
                            <option selected value="{{$user['id']}}">{{$user['name']}}</option>
                            @else
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Recieved & checked date: </label>
                        <input type="date" class="form-control click-date" id="checked_date" name="checked_date" value="{{isset($services['checked_date']) ? date('d-m-Y h:m:s',strtotime($services['checked_date'])):''}}"  required>
                    </div>
                    <div class="col-4 form-group">
                        <label>Recieved & checked by: </label>
                        <select  name="checked_by" class="form-select" value="">
                            <option value="0">Select </option>
                            @foreach ($users as $user)
                            @if(isset($services['checked_by']) && $services['checked_by']== $user['id'])
                            <option selected value="{{$user['id']}}">{{$user['name']}}</option>
                            @else
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Status: </label>
                        <select  name="status" class="form-select" value="">
                            <option value="0">Select </option>
                            <option @if(isset($services['status']) && $services['status']== '1') selected  @endif value="1">Pending</option>
                            <option @if(isset($services['status']) && $services['status']== '2') selected  @endif value="2">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card p-1">
                <div class="row">
                    <div class="form-group col-4">
                        <label>Suppliers Name: </label>
                        <input type="text" name="suppliers_name" class="form-control click-date" value="{{isset($services['suppliers_name']) ? $services['suppliers_name']:''}}">
                    </div>
                    <div class="col-4 form-group">
                        <label>Suppliers Address: </label>
                        <textarea name="Suppliers_address" id="" class="form-control" cols="30" rows="1" value="{{isset($services['suppliers_address']) ? $services['suppliers_address']:''}}"></textarea>
                        {{-- <input type="text-area" class="form-control" id="start_time" name="start_time"  required> --}}
                    </div>
                    <div class="form-group col-4" >
                        <label>Invoice Number: </label>
                        <input type="number" name="invoice_no" class="form-control click-date" value="{{isset($services['invoice_no']) ? $services['invoice_no']:''}}">
                    </div>
                    <div class="form-group col-4">
                        <label>Order Number: </label>
                        <input type="number" name="order_no" class="form-control click-date" value="{{isset($services['order_no']) ? $services['order_no']:''}}">
                    </div>
                    <div class="form-group col-4">
                        <label>Invoice Price: </label>
                        <input type="text" name="price" class="form-control click-date" value="{{isset($services['invoice_price']) ? $services['invoice_price']:''}}">
                    </div>
                    <div class="col-4 form-group">
                        <label>Manager Name: </label>
                        <select  name="manager_name" class="form-select" value="">
                            <option value="0">Select </option>
                            @foreach ($users as $user)
                            @if(isset($services['manager_name']) && $services['manager_name']== $user['id'])
                            <option selected value="{{$user['id']}}">{{$user['name']}}</option>
                            @else
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Authorised By: </label>
                        <option value="0">Select </option>
                        <select  name="auth_by" class="form-select" value="">
                            @foreach ($users as $user)
                            @if(isset($services['auth_by']) && $services['auth_by']== $user['id'])
                            <option selected value="{{$user['id']}}">{{$user['name']}}</option>
                            @else
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Invoice Checked: </label>
                        <select  name="invoice_checked" class="form-select" value="" required>
                            <option value="0">Select </option>
                            <option @if(isset($services['invoice_checked']) && $services['invoice_checked']== '1') selected  @endif value="1">No</option>
                            <option @if(isset($services['invoice_checked']) && $services['invoice_checked']== '2') selected  @endif value="2">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label>Manager Accepted: </label>
                        <select  name="manager_accepted" class="form-select" value="" required>
                            <option value="0">Select </option>
                            <option @if(isset($services['manager_accepted']) && $services['manager_accepted']== '1') selected  @endif value="1">No</option>
                            <option @if(isset($services['manager_accepted']) && $services['manager_accepted']== '2') selected  @endif value="2">Yes</option>
                        </select>
                    </div>
                    <div class="col-4 form-group">
                        <label>Ready to pay: </label>
                        <select  name="ready_to_pay" class="form-select" value="" required>
                            <option value="0">Select </option>
                            <option @if(isset($services['ready_to_pay']) && $services['ready_to_pay']== '1') selected  @endif value="1">No</option>
                            <option @if(isset($services['ready_to_pay']) && $services['ready_to_pay']== '2') selected  @endif value="2">Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-4" >
                        <label>Report: </label>
                        <input type="file" name="report" class="form-control click-date" value="">
                    </div>
                    <div class="form-group col-4 " >
                        <label>Vehicle unavailable during this time: </label>
                        <select  name="availability" class="form-select" value="" required >
                            <option value="0">Select </option>
                            <option @if(isset($services['availability']) && $services['availability']== '1') selected  @endif value="1">No</option>
                            <option @if(isset($services['availability']) && $services['availability']== '2') selected  @endif value="2">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card p-3">
            <div class="row">
                <div class="form-group col-3" >
                    <label>Service Type: </label>
                    <select  name="service_type" class="form-select" value="">
                        <option value="0">Select </option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Brake Wear and Failure') selected  @endif value="Brake Wear and Failure">Brake Wear and Failure</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Engine Maintenance') selected  @endif value="Engine Maintenance">Engine Maintenance</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Prevent Body Problems') selected  @endif value="Prevent Body Problems">Prevent Body Problems</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Electrical System Issues') selected  @endif value="Electrical System Issues">Electrical System Issues</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Replace Parts') selected  @endif value="Replace Parts">Replace Parts</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Maintain Lubrication') selected  @endif value="Maintain Lubrication">Maintain Lubrication</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Change Oil') selected  @endif value="Change Oil">Change Oil</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Monitor Coolant System') selected  @endif value="Monitor Coolant System">Monitor Coolant System</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Air Pressure in Tyres') selected  @endif value="Air Pressure in Tyres">Air Pressure in Tyres</option>
                        <option @if(isset($services['service_type']) && $services['service_type']== 'Check Fuel and Storage Tank') selected  @endif value="Check Fuel and Storage Tank">Check Fuel and Storage Tank</option>
                    </select>
                </div>
                <div class="form-group col-9">
                    <table class="table">
                        <tr>
                            <th>Spare Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                        <tbody id="openOrderBody">
                            @if(isset($spares))
                            @foreach ($spares as $val)
                            <tr class="all_tr_td_values">
                                <td>
                                    <input type="text" class="form-control" id="spare0" name="spare_name[]" value="{{$val['spare_name']}}" >
                                    <input type="hidden" class="form-control" id="spare0" name="spare_id[]" value="{{$val['id']}}" >
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="quantity" name="quantity[]" value="{{$val['quantity']}}" >
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="unit_price" name="unit_price[]" value="{{$val['unit_price']}}" >
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="total_price" name="total_price[]" value="{{$val['total_price']}}"  >
                                </td>
                                <td>
                                    <button onclick="addRow('openOrderBody');" id="add-more" type="button"
                                        class="btn btn-info"><i class="fa fa-plus"></i></button>
                                        <label onclick="get_id(this)" data-name="delete" data-row="0"
                                        class="delrow btn btn-danger"><i class="fa fa-trash"></i></label>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="all_tr_td_values">
                                <td>
                                    <input type="text" class="form-control" id="spare0" name="spare_name[]"  >
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="quantity" name="quantity[]"  >
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="unit_price" name="unit_price[]"  >
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="total_price" name="total_price[]"  >
                                </td>
                                <td>
                                    <button onclick="addRow('openOrderBody');" id="add-more" type="button"
                                        class="btn btn-info"><i class="fa fa-plus"></i></button>
                                        <label onclick="get_id(this)" data-name="delete" data-row="0"
                                        class="delrow btn btn-danger"><i class="fa fa-trash"></i></label>
                                </td>
                            </tr>
                            @endif

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>
    <button type="submit" class="btn btn-sm btn-success pull-right">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script>
setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);
function getStatus(id){
    if(id==1){
        $('#note-status').show();
    }else if(id==2){
        $('#note-status').show();
    }else{
        $('#note-status').hide();
    }
}
function addRow(content_id, label_checkbox='')
  {
    var ac_type=$('#account_type').val();
    //alert(ac_type);
    var row = $("#"+content_id+" tr:last");
    row.clone().find("input, textarea, select, button, checkbox, radio, label").each(function(j,obj)
    {

        i           = $(this).data('row') + 1;
        id          = $(this).data('name') + i;
		label_for   = $(this).data('name') + i;
          //$(this).val('').attr({'id' : id, 'data-row' : i, 'for' : label_for});
		  $(this).val(obj.value).attr({'id' : id, 'data-row' : i, 'for' : label_for});


    }).end().appendTo("#"+content_id);
  }
  function get_id(e){
        var id=$(e).data('row')+1;
        alert(id);
        console.log(id);
        if(id !=0){
            $('#spare'+id).parent().parent().remove();
       }
     }

</script>
@endsection
