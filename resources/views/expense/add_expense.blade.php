@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">Add Expense</h3>
                        </div>

                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif
                            <form id="form" method="post" action="{{route('exp_dtl.exp_store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Select Expense<span class="error">*</span></label>

                                        <div class="form-group">
                                            <select  id='expID' class="form-select select  @error('expID') is-invalid @enderror"  name="expID" >
                                            <option value="">--Select--</option>
                                            @foreach($cdata as $cdata)
                                            <option value="{{$cdata->id}}">{{$cdata->name}}</option>
                                            @endforeach
                                            </select>
                                            @error('expID')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>                                       
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Date<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="DATE" id='expdate' class="form-control  @error('expdate') is-invalid @enderror" name="expdate" />
                                            @error('expdate')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="">Description<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='expdesc' class="form-control  @error('expdesc') is-invalid @enderror" name="expdesc" />
                                            @error('expdesc')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Amount<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="number" id='amount' class="form-control  @error('amount') is-invalid @enderror" name="amount"  required/>
                                            @error('amount')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                    
                                </div>




                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Save and Update</button>
                                        <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                    </div>
                                </div>
                        </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Expense  Details</h5>
                        <div class="card-body">
                            <form action="" id='filter'>
                                <div class="row mb-2">
                                    <?php
                            // echo $start_date;
                                    // $now = date('Y-m-d');
                                    // $start_date = date('Y-m-d', strtotime($now . ' -1 month'));
                                    ?>
                                    <div class="col-md-2">
                                        <label for="">Month</label>
                                        <select  id='month' class="form-select txt-num  @error('month') is-invalid @enderror"  name="month" >
                                            
                                    </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Year</label>
                                        <select  id='year' class="form-select txt-num  @error('year') is-invalid @enderror"  name="year" >
                                            
                                    </select>
                                       
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary submit">Filter</button>
                                        </div>
                                    </div>
        
        
                                </div>
                            </form>
                <div class="row pb-5">

                <table id="datatable" class='table table-striped'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Expense</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>                            

                            <th>Action</th>                            
                                                  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $val)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$val->expense}}</td>
                            <td>{{$val->expdate}}</td>
                            <td>{{$val->expdesc}}</td>
                            <td>{{$val->amount}}</td>
                            
                      <td><button value='{{$val->id}}'  class='btn btn-primary edit_form'>Edit</button>
                      <button value='{{$val->id}}'  class='btn btn-danger delete_modall'>Delete</button></td>
                        </tr>
                        @endforeach
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
</div>
</div>
<script>
   
     const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  let qntYears = 4;
  let selectYear = $("#year");
  let selectMonth = $("#month");
  let selectDay = $("#day");
  let currentYear = new Date().getFullYear();

  for (var y = 0; y < qntYears; y++) {
    let date = new Date(currentYear);
    let yearElem = document.createElement("option");
    yearElem.value = currentYear
    yearElem.textContent = currentYear;
    selectYear.append(yearElem);
    currentYear--;
  }

  for (var m = 0; m < 12; m++) {
    let month = monthNames[m];
    let monthElem = document.createElement("option");
    monthElem.value = m+1;
    monthElem.textContent = month;
    selectMonth.append(monthElem);
  }

  var d = new Date();
  var month = d.getMonth();
  var year = d.getFullYear();
  var day = d.getDate();

  selectYear.val(year);
  selectYear.on("change", AdjustDays);
  selectMonth.val(month);
  selectMonth.on("change", AdjustDays);

  AdjustDays();
  selectDay.val(day)

  function AdjustDays() {
    var year = selectYear.val();
    

var month = parseInt(selectMonth.val()) + 1;
    selectDay.empty();

    //get the last day, so the number of days in that month
    var days = new Date(year, month, 0).getDate();

    //lets create the days of that month
    for (var d = 1; d <= days; d++) {
      var dayElem = document.createElement("option");
      dayElem.value = d;
      dayElem.textContent = d;
      selectDay.append(dayElem);
    }
  }


        $('form[id="form"]').validate({

        ignore: '.select2-input, .select2-focusser',
        
        rules: {
            expID: 'required',
            expdate:'required',
            expdesc:'required',
            amount:'required',


        },
        messages: {
            expID: 'This Expense  is Required',
            expdate:'This Expense Date  is Required',
            expdesc:'This Expense Description  is Required',
    
        },
        errorPlacement: function(label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
        highlight: function(element, errorClass) {
            $(element).parent().addClass('has-danger')
            $(element).addClass('form-control-danger')
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-danger')
            $(element).parent().removeClass('form-control-danger')
        },
        submitHandler: function(form) {

            form.submit();
        }

    });
    $(document).ready(function() {
        var m="<?php echo $month ?>";
  var y="<?php echo $year ?>";
  console.log(y);
    $("#month").val(m).select2();
    $("#year").val(y).select2();

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);



    $(".edit_form").click(function(){
        $("#form").load("content.html");
        id=$(this).val();
        $.ajax({
           type:'get',
           data:{
            id:id
           } ,
           url:"{{route('exp_dtl.index')}}",
           success: function(data)
            {
                	

                $("#expID").val(data.data.expID).select2();
                $("#expdate").val(data.data.expdate);
                $("#expdesc").val(data.data.expdesc);
                $("#amount").val(data.data.amount);
                $("#mop").val(data.data.mop);
                
                $(".card-title").html('Edit Expense').css('color','red');
                   $("#id").val(data.data.id);
                   $("#expID").focus();
                   scrollToTop();
            }
        }); 
    });



        $(".delete_modall").click(function(){
            
            id=$(this).val();
            $("#delete_id").val(id);
          $("#delete_modal").modal('show');
        });
        $("#delete").click(function(){
            
            id=$('#delete_id').val();
            $.ajax({
               type:'post',
               data:{
                "_token": "{{ csrf_token() }}",
                id:id,
                
               } ,
               url:"{{route('exp_dtl.exp_delete')}}",
               success: function(data)
                {
                   $("#delete_modal").modal('hide');
                   document.location.reload();
                }
            }); 
        });

        $('#datatable').DataTable({
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                 'excel'
            ]
        });
        
        

        
       
    });
    
</script>
@endsection