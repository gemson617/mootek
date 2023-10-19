@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
        @include('layouts.partials.menu')
            <div class="col-md-12">
                <h4 class="page-title"> Suburbs</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Suburbs</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Edit Suburb') }}</div>

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
                        <form method="post" action="{{route('admin.update-suburb')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                <label for="">Name:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" value="{{ $data->name }}" class="form-control">
                                    <input type="hidden" value="{{ $data->id }}" name="id" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Post Code<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" onkeypress="return isNumberKey(event)" name="post_code" value="{{ $data->post_code }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>State<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="state" value="{{ $data->state }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Long num :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="long_num" value="{{ $data->long_num }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Lat num :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="lat_num" value="{{ $data->lat_num }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Surcharge num :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="surcharge_num" value="{{ $data->surcharge_num }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('iddeliveryregion :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="iddeliveryregion" value="{{ $data->iddeliveryregion }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/list-suburb" class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to
                                        list</button>&nbsp;&nbsp;&nbsp;
                                        <a href="/list-suburb" class="btn btn-sm btn-danger mr-1">Cancel</a>
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