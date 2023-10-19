@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu') */?>
            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Admin > Suburbs </h4>
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Suburb</a></li>
                    </ol>
                </div>
            </div>

            <div class="col-sm-12">
      <div class="card border-left-primary shadow h-100 ">
         <div class="card-header">
            <h3 class="card-title">Record Suburb</h3>
         </div>

         <div class="card-body ">
            <div class="table-responsive ">
               <table class="table m-0  table-striped  table-vcenter table-bordered">
                  <tbody class="p-0">
                     <tr>
                        <td><strong>Name :</strong></td><td>{{ $suburb->name }}</td>
                     </tr>
                     <tr>
                        <td><strong>Post Code :</strong></td><td>{{ $suburb->post_code }}</td>
                     </tr>
                     <tr>
                        <td><strong>State :</strong></td><td>{{ $suburb->state }}</td>
                     </tr>
                     <tr>
                        <td><strong>Long num :</strong></td><td>{{ $suburb->long_num }}</td>
                     </tr>
                     <tr>
                        <td><strong>Lat num :</strong></td><td>{{ $suburb->lat_num }}</td>
                     </tr>
                     <tr>
                        <td><strong>Surcharge num :</strong></td><td>{{ $suburb->surcharge_num }}</td>
                     </tr>
                     <tr>
                        <td><strong>Iddeliveryregion :</strong></td><td>{{ $suburb->iddeliveryregion }}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
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
