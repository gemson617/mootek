@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        <div class="">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <label for="">
                    <h2>Attendance List</h2>
                </label>
        </div>
            <div class="col-md-4 d-flex align-items-end justify-content-end mb-2">
            <a href="{{route('attendance.index')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Attendance<i class="la la-plus"></i>

                                    </button>
								</a>
            </div>
        </div>
       
       
      
            <div class="row">
                <div class="card border-left-primary shadow h-100 ">
                    <div class="card-header">
                        <h3 class="card-title"> Attendance List</h3>
                    </div>

                    <div class="card-body">
                        <form action="" id='filter'>
                            <div class="row mb-2 ">
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
                        <div class="row">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Attendance Date</th>
                                        <th>Attendance Time</th>
                                         <th>Status</th>
                                       <th>Active</th> 
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all as $key=>$val)
                                    <tr>
                                        <td>{{$val->name}}</td>
                                        <?php  $date = date("d-m-Y", strtotime($val->attdate)); ?>
                                        <td>{{$date}}</td>
                                        <td>{{$val->atttime}}</td>
                                        <td>{{$val->status}}</td>
                                       <td><?php echo $val->active=='1'?'Active':'Inactive'; ?></td>
                                        <td>
                                            <a href="/attendanceedit/{{$val->id}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                            <i class="fa fa-trash delete_modal" id="{{$val->id}}" style="font-size:22px;color:red"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>


                    </div>

                    </form>

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

        $(document).ready(function() {
            var m="<?php echo $month ?>";
  var y="<?php echo $year ?>";
  console.log(y);
    $("#month").val(m).select2();
    $("#year").val(y).select2();

            $('#datatable').dataTable({
                "ordering": false
            });
            $(".delete_modal").click(function() {

id = $(this).attr('id');
$("#delete_id").val(id);
$("#delete_modal").modal('show');
});
$("#delete").click(function() {

id = $('#delete_id').val();
$.ajax({
    type: 'post',
    data: {
        "_token": "{{ csrf_token() }}",
        id: id,

    },
    url: "{{route('attendance.attendance_delete')}}",
    success: function(data) {
        $("#delete_modal").modal('hide');
        document.location.reload();
    }
});
});
        });
   
    </script>
    @endsection