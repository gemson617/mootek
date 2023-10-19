@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="row justify-content-center">
        @include('layouts.partials.menu')
            <div class="col-md-12">
                <h4 class="page-title">Offices</h4>
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item"><a href="#">Offices</a></li>
                </ol>
                <div class="card">
                    <div class="card-header">{{ __('Edit Office') }}</div>

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
                        <form method="post" action="{{ route('admin.update-office') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                <label for="">Address Name:<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="address_name" value="{{ $result->address_name }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('First Name :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="first_name" value="{{ $result->first_name }}" class="form-control">
                                    <input type="hidden" name="id" value="{{ $result->id }}" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Last Name :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="last_name" value="{{ $result->last_name }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Street Name :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="street_name" value="{{ $result->street_name }}" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="row ">
                                <div class="col-md-3">
                                    <label>{{ __('Suburb :') }}</label>
                                </div>
                                <div class="col-md-8">
                                       <input type="text" id = "srch_suburb" name="srch_suburb"
                                       onkeyup="postcodeSearch('srch_suburb','srch_post_code','postsearch',this);"  class="form-control "
                                     value="{{$result->suburb}}" >
                                </div>
                                <div id="postsearch" data-suburb="srch_suburb" data-postcode="srch_post_code" data-subid="srch_subid"
                                    style="width:100%; background-color:#fff; border:2px soild #000;" class="text-center">

                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-md-3">
                                    <label>{{ __('Postcode :') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text"  id = "srch_post_code" name="srch_post_code"
                                    class="form-control " onkeyup="postcodeSearch('srch_suburb','srch_post_code','postsearch',this);" autocomplete="off" value="{{$result->postcode}}" >
                                    <input type="hidden" id="srch_subid" name="srch_subid" value="">


                                </div>
                            </div>
                            <br>

                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="/list-office" class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to
                                        list</button>&nbsp;&nbsp;&nbsp;
                                        <a href="/list-office" class="btn btn-sm btn-danger mr-1">Cancel</a>
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


function postcodeSearch(suburb,post_code,div,e) {
        if( $(e).val().length < 3)
        {
            return;
        }
        postcode_val = $('#'+post_code).val();
		suburb_val =  $('#'+suburb).val();
        $.ajax({
                type: "GET",
                url: '{{route("customer.customer-loadpostcode")}}',
                data: {'srch_post_code': postcode_val, 'srch_suburb': suburb_val},
                success: function(data) {
                    $('#'+div).html('');
                    //alert(data);
                    if(data){
                        $('#'+div).html(data);
                        $('#'+div).show();
                }
            }
    });

  }
    function customerSearch() {
        acc_no = $("#acc_no").val();
	   status = $("#status").val();
        email = $("#email").val();
        first_name = $("#first_name").val();
        last_name = $("#last_name").val();
        company = $("#company").val();
        abn = $("#abn").val();
        alias = $("#alias").val();
        unit_no = $("#unit_no").val();
        street_no = $("#tabl").val();
        street_name = $("#street_name").val();
        street_type = $("#street_type").val();

        $.ajax({
                type: "GET",
                url: '{{route("customer.customer-customersearch")}}',
                data: {'acc_no': acc_no, 'status': status, 'email': email, 'first_name': first_name, 'last_name': last_name, 'company': company,
                'abn': abn, 'street_no': street_no, 'alias': alias, 'unit_no': unit_no, 'street_name': street_name, 'street_type': street_type},
                success: function(data) {

                    $('#postsearch').html('');
                    //console.log(data);
                    if(data){
                        for (var i = 0; i < data.length; i++)
                    {
                        document.getElementById("postsearch").innerHTML =data;

                    }

                }
            }
    });

  }
  function  setPostCode(id,post_code,name,state,e) {
        $('#'+jQuery(e).parent().attr('data-suburb')).val(name);
        $('#'+jQuery(e).parent().attr('data-postcode')).val(post_code);
        $(e).parent().hide();
        $('#'+jQuery(e).parent().attr('data-subid')).val(id);
  }
function clearPostCode()
	{
		$('#suburb').val(null);
        $('#srch_post_code').val(null);
		$("#showSuburb").hide();
        $("#notset").show();

	}

</script>
@endsection
