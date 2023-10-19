@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        <div class="">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <label for="">
                    <h2>SCRAP List</h2>
                </label>
            </div>
            <div class="col-md-4 d-flex align-items-end justify-content-end mb-2">
            <a href="{{route('scrap.index')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Scrap<i class="la la-plus"></i>

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
                                        <th>Vendor</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                        <th>Payment Mode</th>
                                        <!-- <th>Tax Price</th>
                                    <th>Total Price</th> -->
                                        <th>View</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all as $key=>$val)
                                    <tr>
                                        <td>{{$val->supplier_name}}</td>
                                        <?php  $date = date("d-m-Y", strtotime($val->date)); ?>
                                        <td>{{$date}}</td>
                                        <td>{{$val->price}}</td>
                                        <td>{{$val->payment_mode}}</td>
                                        <!-- <td>{{$val->tax_price}}</td>
                                    <td>{{$val->total_price}}</td> -->
                                        <td><a href="/view/{{$val->id}}"><i class="fa fa-eye" style="color:blue" aria-hidden="true"></i></a></td>
                                        <td>
                                            <a href="/scrap/edit/{{$val->id}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
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