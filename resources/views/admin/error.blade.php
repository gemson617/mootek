@extends('layouts.app')


@section('content')
<style>


h1 {
color: red;
}

h6{
color: red;
text-decoration: underline;
}
</style>
<div class="app-content page-body">
    <div class="container" style="padding-top: 150px;">
        <div class="text-center">

            <div class="w3-display-middle">
                <h1 class="w3-jumbo w3-animate-top w3-center"><code>Access Denied</code></h1>
                <hr class="w3-border-white w3-animate-left" style="margin:auto;width:50%">
                <h3 class="w3-center w3-animate-right">Sorry, you dont have permission to view this page.</h3>
                <h3 class="w3-center w3-animate-right">Contact your System Administrator.</h3>


                </div>
        </div>
    </div>
</div>
@endsection
