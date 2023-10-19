@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
        @include('layouts.partials.menu')
            <div class="col-md-12">
                <h4 class="page-title">Trucks & Dispatch</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Trucks & Dispatch</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Edit Trucks & Dispatch') }}</div>

                    <div class="card-body">

                        @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                        @endforeach
                        @endif

                        @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                        @endif
                        <form method="post" action="{{route('admin.update-truck-dispatch')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Type:</label>
                                    <input type="text" name="type" value="{{$data->type}}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Alias:</label>
                                    <input type="text" name="alias" value="{{$data->alias}}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Make:<span class="error">*</span></label>
                                    <input type="text" name="make" value="{{ $data->make }}" class="form-control">
                                    <input type="hidden" value="{{ $data->id }}" name="id" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Model:</label>
                                    <input type="text" name="model" value="{{$data->model }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Registration Number:<span class="error">*</span></label>
                                    <input type="text" name="rego" value="{{ $data->rego }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">year:</label>
                                    <input type="text" name="year" value="{{$data->year }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Rego Expiry:</label>
                                    <input type="date" name="rego_expiry" value="{{$data->rego_expiry }}" class="form-control click-date">
                                </div>
                                <div class="col-md-4">
                                    <label for="">klms:</label>
                                    <input type="text" name="klms" value="{{$data->klms }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">VIN number:</label>
                                    <input type="text" name="vin_number" value="{{$data->vin_number }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Status:</label>
                                    <input type="text" name="status" value="{{$data->status }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Tank Capacity:</label>
                                    <input type="text" name="tank_capacity" value="{{$data->tank_capacity }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Fuel Capacity:</label>
                                    <input type="text" name="fuel_capacity" value="{{$data->fuel_capacity }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            {{-- <div class="row">
                                <div class="col-md-4">
                                    <label for="">Company name:</label>
                                    <input type="text" name="company_name" value="{{$data->company }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Branch:</label>
                                    <input type="text" name="branch" value="{{$data->branch }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Employee:</label>
                                    <input type="text" name="employee" value="{{$data->employee }}" class="form-control">
                                </div>
                            </div> --}}
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Insurance Expiry:</label>
                                    <input type="date" name="coc_expiry" value="{{$data->coc_expiry }}" class="form-control click-date">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Vehicle Status:</label>
                                    <select onchange="getStatus(this.value)" name="vehicle_status" class="form-control">
                                            <option value=''>Select Status</option>
                                            <option {{ ($data->vehicle_status==0) ? 'selected':'' }} value='0'>Active</option>
                                            <option {{ ($data->vehicle_status==1) ? 'selected':'' }} value='1'>In-Active</option>
                                            <option {{ ($data->vehicle_status==2) ? 'selected':'' }} value='2'>Under Maintanence</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">COI Expiry:</label>
                                    <input type="date" name="coi" value="{{$data->coi}}" class="form-control click-date">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Images:</label>
                                    <input type='hidden' name='old_image' value="{{$data->images}}" />
                                    <input type="file" accept="image/png, image/jpeg"  name="images" value="" class="form-control">
                                </div>
                                <?php if(!empty($data->images)){ ?>
                                <div class="col-md-3">
                                        <img src="{{ asset($data->images) }}" />
                                </div><?php } ?>
                                @if(!empty($data->notes))
                                <div class="col-md-6"  id="note-status" style="display:block">
                                    <label for="">Notes:</label>
                                   <textarea class="form-control" name="notes">{{$data->notes}}</textarea>
                                </div>
                                @else
                                <div class="col-md-6"  id="note-status" style="display:none">
                                    <label for="">Notes:</label>
                                   <textarea class="form-control" name="notes"></textarea>
                                </div>
                                @endif
                            </div>
                            <br>






                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/list-truck-dispatch" class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to
                                        list</button>&nbsp;&nbsp;&nbsp;
                                        <a href="/list-truck-dispatch" class="btn btn-sm btn-danger mr-1">Cancel</a>
                                </div>
                            </div>







                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
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
</script>
@endsection
