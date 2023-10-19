@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts.partials.menu')

            <div class="col-md-12">
                <h4 class="page-title"> Trucks & Dispatch</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Trucks & Dispatch</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Add Trucks & Dispatch') }}</div>

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
                        <form method="post" enctype="multipart/form-data" action="{{route('admin.add-truck-dispatch')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Type:</label>
                                    <input type="text" name="type" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Alias:</label>
                                    <input type="text" name="alias" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Make:<span class="error">*</span></label>
                                    <input type="text" name="make" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Model:</label>
                                    <input type="text" name="model" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Registration Number:<span class="error">*</span></label>
                                    <input type="text" name="rego" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">year:</label>
                                    <input type="text" name="year" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Rego Expiry:</label>
                                    <input type="date" name="rego_expiry" value="" class="form-control click-date">
                                </div>
                                <div class="col-md-4">
                                    <label for="">klms:</label>
                                    <input type="text" name="klms" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">VIN number:</label>
                                    <input type="text" name="vin_number" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Status:</label>
                                    <input type="text" name="status" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Tank Capacity:</label>
                                    <input type="text" name="tank_capacity" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Fuel Capacity:</label>
                                    <input type="text" name="fuel_capacity" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            {{-- <div class="row">
                                <div class="col-md-4">
                                    <label for="">Company name:</label>
                                    <input type="text" name="company_name" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Branch:</label>
                                    <input type="text" name="branch" value="" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Employee:</label>
                                    <input type="text" name="employee" value="" class="form-control">
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Insurance Expiry:</label>
                                    <input type="date" name="coc_expiry" value="" class="form-control click-date">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Vehicle Status:</label>
                                    <select onchange="getStatus(this.value)" name="vehicle_status" class="form-control">
                                            <option value=''>Select Status</option>
                                            <option value='0'>Active</option>
                                            <option value='1'>In-Active</option>
                                            <option value='2'>Under Maintanence</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">COI Expiry:</label>
                                    <input type="date" name="coi" value="" class="form-control click-date">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Images:</label>
                                    <input type="file" accept="image/png, image/jpeg"  name="images" value="" class="form-control">
                                </div>
                                <div class="col-md-6" id="note-status" style="display:none">
                                    <label for="">Notes:</label>
                                   <textarea class="form-control" name="notes"></textarea>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="list-truck-dispatch"
                                        class="btn btn-sm btn-primary mr-1">Back</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to
                                        list</button>&nbsp;&nbsp;&nbsp;
                                    <button type="reset" class="btn btn-sm btn-danger mr-1">Cancel</button>
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
