@extends('layouts.app')

@section('content')
<div class="app-content page-body">

    <div class="container">
    <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <label for="">
                    <h2>Invoice List</h2>
                </label>
            </div>
            {{-- <div class="col-md-4 d-flex align-items-end justify-content-end mb-2">
            <a href="{{route('sale.index')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Sale<i class="la la-plus"></i>

                                    </button>
								</a>
            </div> --}}
        </div>
        <div class="row">
            <div class="card border-left-primary shadow h-100 ">
                <div class="card-header">
                    <h3 class="card-title"> Receipt List</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <table id="datatable" class=" datatable table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Purchased Date</th>
                                    <th>Receipt No</th>
                                    <th>During Days </th>
                                    <th>Customer</th>
                                    <th>Received Date</th>
                                    <th>Taxable Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Received Amount</th>                                 
                                    <th>Receipt</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment as $val)
                                <tr>
                                    <td>{{$val->invoiceID}}</td>
                                    <?php
                                    $purchased_date = date("d-m-Y", strtotime($val->purchased_date));
                                    ?>
                                    <td>{{$purchased_date}}</td>
                                    <td>{{$val->invoiceNo}}</td>
                                    <td><?php $datediff =  strtotime($val->paymentDate) -strtotime($val->purchased_date);
                                    echo round($datediff / (60 * 60 * 24)) +1;
                                    ?></td>
                                    <td>{{$val->name}}</td>
                                        <?php
                                    $paymentDate = date("d-m-Y", strtotime($val->paymentDate));
                                    ?>
                                    <td>{{$paymentDate}}</td>
                                    <td>{{$val->amount}}</td>
                                    <td>{{$val->balance}}</td>
                                    <td>{{$val->collected}}</td>
                                    <td><a href="{{$val->invoice_path}}" style='text-decoration:none;color:black' target="_blank"><i class="fa-solid fa-receipt"></i></a></td>
                                  
                                    <!-- <td> <a href="edit-invoice.php?id={$row['id']}&cusID={$row['customerID']}&tax={$row['tax']}"><i class="zmdi zmdi-edit zmdi-hc-fw" style="color:blue;"></i></a></td> -->
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
        $('.datatable').DataTable({
            "ordering": false
        });
    });
    
   
</script>
@endsection