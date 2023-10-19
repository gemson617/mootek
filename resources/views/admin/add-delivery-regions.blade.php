@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
				@include('layouts.partials.menu')

            <div class="col-md-12">
                <h4 class="page-title"> Delivery Regions</h4>
                <ol class="breadcrumb pl-0">
										<li class="breadcrumb-item"><a href="#">Home</a></li>
										<li class="breadcrumb-item"><a href="#">Delivery Regions</a></li>
									</ol>
                <div class="card">
                    <div class="card-header">{{ __('Add Delivery Regions') }}</div>
                   
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
                        <form method="post" action="{{route('admin.add-delivery-regions')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                <label for="">Name:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Delivery Days :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="delivery_days" value="" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Dispatch From :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <select  name="dispatch_from"  class="form-control">
                                        <option>Select Office</option>
                                        @foreach($office as $row)
                                        <option value="{{ $row->id }}">{{$row->address_name}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="list-delivery-regions" class="btn btn-sm btn-primary mr-1">Back</a>&nbsp;&nbsp;&nbsp;&nbsp;
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
</script>
@endsection