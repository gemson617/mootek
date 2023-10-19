@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
        @include('layouts.partials.menu')
            <div class="col-md-12">
                <div class="row">
                    <h4 class="page-title col-6">Truck Maintenance Records - {{$trucks['make']}} {{$trucks['rego']}}</h4>
                    <div class="col-6">
                        @permission('add-service')
                        <a href="/add-service-record/{{$trucks['id']}}" class=" btn btn-sm btn-primary pull-right" >Create Service Record</a>
                        @endpermission
                    </div>

                </div>

                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Trucks & Dispatch</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row ml-2">
        @if(isset($services_det))
        <div class="col-6">
            <table class="table table-striped table-bordered" style="width: 100%;">
                <thead class="bg-azure-lighter">
                    <tr>
                        <th>Service_id</th>
                        <th>Service Type</th>
                        <th>Required Spares</th>
                        <th>Status</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services_det as $key=>$val )
                    <tr>
                        <td>{{$val['id']}}</td>
                        <td>{{$val['service_type']}}</td>
                        <td>
                            @if(isset($val['spares']))
                            @foreach ($val['spares'] as $row )
                                <strong>{{$row['spare_name']}}</strong> X {{$row['quantity']}} <br>
                            @endforeach
                            @endif
                        </td>
                        <td>@if($val['status']==1)Pending @else Completed @endif</td>
                        <td>
                            @permission('eidt-service')
                            <a title="View & Edit" href="/edit-service-record/{{$trucks['id']}}/{{$val['id']}}"  class="btn btn-sm btn-success">
                                <i class="fa fa-pencil"></i>
                            </a>
                            @endpermission
                            @permission('delete-service')
                            <a title="Delete" href="javascript:void(0)" onclick="delete_service('{{$val['id']}}')" type="button" class="btn btn-sm btn-danger">
                                <i class="fa fa-times"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

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
function edit_service(id) {

            $.ajax({
                type: "POST",
                //
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    if (data == 1) {
                        window.location.reload();
                    }
                },
                error: function(data, textStatus, errorThrown) {
                },
            });
}
</script>
@endsection
