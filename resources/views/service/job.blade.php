@extends('layouts.app')

@section('content')
<div class="app-content page-body">

    <div class="container">
        <div class="row d-flex justify-content-between">

            <div class="col-md-4">
                <label for="">
                    <h2>Job List</h2>
                </label>
            </div>
            <div class="col-md-4 d-flex align-items-end justify-content-end mb-2">
            <a href="/add-lead" aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Lead<i class="la la-plus"></i>
                                    </button>
								</a>
            </div>
        </div>
        <div class="row">
            <div class="card border-left-primary shadow h-100 ">
                <div class="card-header">
       
                    <h3 class="card-title">Job Order</h3>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ticket id</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Action</th>

                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $key=>$val)
                            <tr>
                                <td>{{$val->id}}</td>
                                <td>{{$val->lead_name}}</td>
                                <td>{{$val->date}}</td>
                                <td>
                                    @if($val->status ==1)
                                    <button class="btn btn-primary" id='acceptjob' data={{$val->id}}> Accept </button>
                                    @else
                                    <a href="/jobproduct/{{$val->id}}"><button class="btn btn-info"  data={{$val->id}}> View </button></a>
                                    
                                      
                                    @endif
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>

                </form>

            </div>
        </div>
        <div id='jobstatus' class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Accept Job</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id='job_id' name='id'>
                    <div class="modal-body">
                        <p>Are you Accept Job?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary delete" id='acceptjobstatus'>Yes,Accept</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
         function assignLead(id) {
            $('#leadModal').modal('show');
            $('#lead_id').val(id);
            // $('#employee_id');
            $("#employee_id").select2({
                dropdownParent: $("#leadModal"),
                width: '100%'
            });
        }
        $("#acceptjob").click(function(){
            id = $(this).attr('data');
            $("#job_id").val(id);
            $("#jobstatus").modal('show');

        });
        $("#acceptjobstatus").click(function() {
                id = $('#job_id').val();
                $.ajax({
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,

                    },
                    url: "{{ route('job.accept') }}",
                    success: function(data) {
                        
                        document.location.reload();
                        
                    }
                });
            });

    $(document).ready(function() {
        $('#datatable').dataTable({
            "ordering": false
        });
    });

    $('#invoice').on('change', function() {
        id = $(this).val();
        $("#form_submit").submit();

    })
</script>
@endsection