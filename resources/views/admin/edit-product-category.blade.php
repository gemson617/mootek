@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
            <?php /*@include('layouts.partials.menu')*/?>

            <div class="col-md-12">
                <h4 class="page-title">Product</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Product</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Edit Product') }}</div>

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

                        <form method="post" action="{{route('admin.update-product-category')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">                                   
                                    <label for="">Name:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $category->name }}" name="name" />
                                        <input type="hidden" name="id" value="{{$category->id}}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                   
                                    <label for="">Product Code:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $category->product_code }}" name="product_code" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Description:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $category->description }}"  name="description" />
                                    </div>
                                </div>
                                <?php /*
                                <div class="col-md-3">
                                    {{ __('Rental Transaction Description:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $category->transaction_description }}" name="transaction_description" />
                                    </div>
                                </div>
                                <div class="col-md-3">                                    
                                    <label for="">Category:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select class="form-control" name="category_id"> 
                                            <option value="">Select Category</option>
                                            @foreach($product as $row)
                                            <option  {{ ($row->id==$category->category_id) ? 'Selected':''  }}     value="{{$row->id}}">{{$row->category_name}}</option>
                                            @endforeach

                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Type:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">                                       
                                        <select class="form-control" name="type">
                                        <option value="">Select Type</option>                                       
                                        <option {{($category->type==1) ? 'selected':''}} value="1">CYLINDER</option>
                                        <option {{($category->type==2) ? 'selected':''}} value="2">HARDGOOD RENTAL</option>
                                        <option {{($category->type==3) ? 'selected':''}} value="3">HARDGOOD SALES</option>
                                        <option {{($category->type==4) ? 'selected':''}} value="4">TRANSACTION</option>
                                        <option {{($category->type==5) ? 'selected':''}} value="5">GAS</option></select>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('RRP $:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$category->rrp}}" name="rrp" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Cost Price $:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$category->cost_price}}" name="cost_price" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    {{ __('Buy Outright Price $:') }}
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{$category->outright_price}}" name="outright_price" />
                                    </div>
                                </div>*/ ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('admin.list-product-category')}}" class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to list</button>                                   
                                    <a href="{{route('admin.list-product-category')}}" class="btn btn-sm btn-danger mr-1">Cancel</a>
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