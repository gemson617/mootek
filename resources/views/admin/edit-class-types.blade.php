@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts.partials.menu')

            <div class="col-md-12">
                <h4 class="page-title">Product Class Types</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#"> Product Class Types</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Edit Classtype') }}</div>

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

                        <form method="post" action="{{route('admin.update-class-types')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                <label for="">Name:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" value="{{ $data->name }}" class="form-control" name="name" />
                                        <input type="hidden" name="id" value="{{ $data->id }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-sm btn-primary mr-1" href="/list-class-types">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>
                                    <a class="btn btn-sm btn-danger mr-1" href="/list-class-types">Cancel</a>

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
</div>
<script>
setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);
</script>
@endsection