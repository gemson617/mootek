@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts.partials.menu')

            <div class="col-md-12">
                <h4 class="page-title">Customer Marketing</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Customer Marketing</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Edit Marketing') }}</div>

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

                        <form method="post" action="{{route('admin.update-marketing-customer')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                <label for="">How Customer Heard About Agas:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" value="{{ $data->about_agas }}" class="form-control"
                                            name="about_agas" />
                                        <input type="hidden" name="id" value="{{ $data->id }}" />
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-sm btn-primary mr-1" href="/list-marketing-customer">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to
                                        list</button>
                                 <a class="btn btn-sm btn-danger mr-1" href="/list-marketing-customer">Cancel</a>
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