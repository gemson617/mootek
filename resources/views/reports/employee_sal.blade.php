@extends('layouts.app')

@section('content')
<style>
    .report-count {
        color: #e37b21;
        font-weight: bolder;
    }
</style>

<div class="app-content page-body">

    <div class="container">

        <div class="row">
            <div class="card border-left-primary shadow h-100 ">
                <div class="card-header">
                    <h3 class="card-title"></h3>
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
                                <select  id='month' class="form-select txt-num   @error('month') is-invalid @enderror" name="month" >
                                    
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
                                    <th>Basic Salary</th>
                                    <th>Total Days</th>
                                    <th>Holidays</th>
                                    <th>Working Days</th>
                                    <th>Absent Days</th>
                                    <th>Overal Days</th>
                                    <th>Employee Loan</th>
                                    <th>Working Salary</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datatable as $key=>$val)
                                <tr>
                                    <td>{{$val->name}}</td>
                                    <td>{{isset($val->basic_salary)?$val->basic_salary:'0'}}</td>
                                    <td>{{$daysInMonth}}</td>
                                    <td>{{$holiday}}</td>
                                    <td>{{$val->working_days}}</td>
                                    <td><?=$daysInMonth-($holiday+$val->working_days);?></td>
                                    <td>{{$holiday+$val->working_days}}</td>
                                    <td><?php echo $val->Loan==null?'-':  $val->Loan;?></td>
                                    <td><?php
                                    $days=$holiday+$val->working_days;
                                    $oneday = $val->basic_salary/$daysInMonth;
                                    $overal_salary=$oneday*$days;
                                    echo number_format($overal_salary,2);
                                    ?></td>
                                   
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
</div>
</div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {

$('#datatable').DataTable({
    "ordering": false,
    dom: 'Bfrtip',
    buttons: [
        'copy', 'excel', {
            extend: 'pdf',
            text: 'PDF',
            exportOptions: {
                columns: ':visible'
            }
        }
    ]
});

});
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
console.log(m);
    $("#month").val(m).select2();
    $("#year").val(y).select2();
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