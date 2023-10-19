@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
           <?php /* @include('layouts.partials.menu') */?>

            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Product </h4>
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Product </a></li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card border-left-primary shadow h-100 ">
                    <div class="card-header">
                        <h3 class="card-title">Add Product </h3>
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
                           
                        <form method="post" action="{{route('admin.store-product')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                <label for="">Name:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <label for="">Product Code:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_code" value="{{ old('product_code') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Description:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="description" value="{{ old('description') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Rental Transaction Description:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="transaction_description" value="{{ old('transaction_description') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <label for="">Category:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control" name="category_id" id="category_id"> 
                                            <option value="">Select Category</option>
                                            @foreach($category as $row)
                                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                                            @endforeach

                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Type:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">                                       
                                        <select class="form-control" name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option value="1">CYLINDER</option>
                                        <option value="2">HARDGOOD RENTAL</option>
                                        <option value="3">HARDGOOD SALES</option>
                                        <option value="4">TRANSACTION</option>
                                        <option value="5">GAS</option></select>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('RRP $:') }}<span class="error">*</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="rrp" value="{{ old('rrp') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Cost Price $:') }}<span class="error">*</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cost_price" value="{{ old('cost_price') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Buy Outright Price $:') }}<span class="error">*</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="outright_price" value="{{ old('outright_price') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Status:') }}<span class="error">*</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">                                       
                                        <select class="form-control" name="status">
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('admin.list-product-category')}}" class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>
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
</div>
<script>
    <?php
    if(old('name'))
    {
        ?>
        jQuery('#category_id').val('<?php echo old('category_id');?>');
        jQuery('#type').val('<?php echo old('type');?>');
        <?php
    }
?>

setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);
</script>
@endsection