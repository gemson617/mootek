@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        <div class="">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <label for="">
                    <h2>Services List</h2>
                </label>
            </div>
            <div class="col-md-4 d-flex align-items-end justify-content-end mb-2">
            <a href="/add-lead" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Lead<i class="la la-plus"></i>

                                    </button>
								</a>
            </div>
        </div>
            <div class="row">
                <div class="card border-left-primary shadow h-100 ">
                    <div class="card-header">
                        <h3 class="card-title"> SCRAP List</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Source</th>
                                        <th>Referrer</th>
                                        <th>Category</th>
                                        <th>Lead Date</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $key=>$val)
                                    <tr>
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->mobile_number}}</td>
                                        <td>{{$val->lead_email}}</td>
                                        <td>{{$val->source_name}}</td>
                                        <td>{{$val->referrer_name}}</td>
                                        <td>{{$val->category_name}}</td>
                                        <?php
                                        $date = date("d-m-Y", strtotime($val->created_at));
                                        ?>
                                        <td>{{$date}}</td>
                                         <td>{{$val->remark}}</td>

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
        $(document).ready(function() {
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
            // alert(id);
            $.ajax({
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,

                },
                url: "{{route('scrap.delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload()
                }
            });
        });
        });
   
    </script>
    @endsection