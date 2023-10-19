@extends('layouts.app')

@section('content')

<style>
.table td {
    cursor: pointer;
}

.table tr:hover td {
    background-color: #d9ebf5;
}

li#task1 {
    padding: 6px;
    line-height: 2em;
}
</style>

<div class="app-content page-body">
    <div class="container">

        <!--Page header-->
        @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
        @endif
        <div class="page-header">
            <div class="page-leftheader">
               
            </div>
            @permission('create-customer')
            <div class="page-rightheader">
                <a href="{{route('admin.add-meeting')}}" class="text-white btn btn-sm btn-primary"><i class="fe fe-plus"></i>
                    Add Meeting</a>
            </div>
            @endpermission
        </div>
        <!--End Page header-->
  

<div class="row">
    {{-- <div class="col-sm-12 ">
        <div class="card "> --}}
            {{-- <div class="card-header">
                Search Results
            </div> --}}
            <div class="card-body">               
                <div class="table table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead class="bg-azure-lighter">
                            <tr>
                                <th class="text-capitalize">Meeting Date</th>                                
                                <th class=" text-capitalize">Start Time</th>
                                <th class=" text-capitalize">End Time</th>
                                <th class=" text-capitalize">Reminder</th>
                                <th class=" text-capitalize">Location</th>
                                <th class=" text-capitalize">Invite List</th>
                                <th class=" text-capitalize">Agenda</th>
                                <th class=" text-capitalize">Metting Link</th>
                                <th class=" text-capitalize">Status</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($meetArr)){                                
                                foreach($meetArr as $row){
                                ?>
                                <tr>
                                    <td><?= $row['meeting_date']; ?></td>
                                    <td><?= $row['start']; ?></td>
                                    <td><?= $row['end']; ?></td>
                                    <td><?= $row['reminder']; ?></td>
                                    <td><?= $row['location']; ?></td>
                                    <td><?php foreach($row['invite_list'] as $val){
                                        echo strtoupper($val->names);
                                    } ?></td>
                                    <td><?= $row['desc']; ?></td>
                                    <td><?= $row['link']; ?></td>
                                    <td><?php 
                                    $cur_date=date('d-m-Y');
                                    $row['meeting_date']; 
                                    if($cur_date < $row['meeting_date']){
                                        echo "Upcoming";
                                    }elseif($cur_date==$row['meeting_date']){
                                        echo "Due Today";
                                    }elseif($cur_date > $row['meeting_date']){
                                        echo "Completed";
                                    }else{}
                                    ?></td>
                                </tr>

                           <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        {{-- </div>
    </div> --}}
</div>

</div>
</div><!-- end app-content-->

<script>



function getRemainder(){
    var url = "<?php echo url('/get-remainder/');?>/<?= date('Y-m-d') ?>";
    $.ajax({
                type: 'GET',
                url: url,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {                   
                   if(data != 0){                     
                     pushNotfication(data)
                   }
                },
                error: function(data) {
                    console.log(data);
                }
            });
}

setInterval(() => {
    getRemainder()
}, 5000);
//setInterval(,5000);

function pushNotfication(id){
    $.ajax({
            type: "POST",
            url: "{{ route('admin.push-remainder') }}",
            data: {
                id:id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                if(data) {
                   console.log(data);
                }
            },
            error: function(data, textStatus, errorThrown) {},
        });
}


</script>


@endsection


