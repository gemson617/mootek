@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/?>

            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Product Category</h4>
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Product Category</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card border-left-primary shadow h-100 ">
                    <div class="card-header">
                        <h3 class="card-title">Add Category</h3>
                    </div>

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

                        <form method="post" action="{{route('admin.add-category')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Name<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control txt-num" name="category" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('admin.list-category')}}" class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>
                                    <a href="{{route('admin.list-category')}}" class="btn btn-sm btn-danger mr-1">Cancel</a>
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
