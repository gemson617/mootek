@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <div class="row">
                @foreach ($qrcode_ist as $val)
                    <div class="card col-md-2">
                        <div class="card-body center">
                            <img src="{{ asset($val)}}">
                        </div>
                        <div class="card-footer">
                            <p>
                              
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
    });

</script>
@endsection