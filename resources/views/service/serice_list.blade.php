@extends('layouts.app')

@section('content')
<div class="app-content page-body">

    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <label for="">
                    <h2>Invoice List</h2>
                </label>
                <form action="" id='form_submit'>
                    <div class="form-group">
                        <select id='invoice' class="form-select txt-num  @error('companyID') is-invalid @enderror" value="" name="companyID" placeholder="rfd">
                            <option value=" ">---Select Invoice List--</option>
                            <option value="1" <?php echo $id == 1 ? 'Selected' : ''; ?> >GST</option>
                            <option value="2" <?php echo $id == 2 ? 'Selected' : ''; ?> >NON GST</option>
                        </select>
                        @error('companyID')
                        <div class="error">*{{$message}}</div>
                        @enderror
                    </div>
                </form>

            </div>
            <div class="col-md-4 d-flex align-items-end justify-content-end mb-2">
            <a href="{{route('add.service')}}" class="btn-"  aria-expanded="false">
                                    <button class='btn btn-primary'>
									Add Serivies<i class="la la-plus"></i>

                                    </button>
								</a>
            </div>
        </div>
        
        <div class="row">
            <div class="card border-left-primary shadow h-100 ">
                <div class="card-header">
                    <h3 class="card-title"> Invoice List</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Tax</th>
                                    <th>Disc</th>
                                    <th>Gra.Total</th>
                                    <th>Bal</th>
                                    <th>Received</th>
                                    <th>Invoice Date</th>
                                    <th>Phone</th>
                                    <th>Invoice</th>
                                    <th>Payment</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase as $key=>$val)
                                <tr>
                                    <td><?php echo isset($val->invoiceID) ? $val->invoiceID : ' '; ?></td>
                                    <td><?php $cusid = App\Models\customer::where('active', '1')->where('id', $val->customerID)->first();
                                        echo isset($cusid->name) ? $cusid->name : " ";
                                        ?></td>
                                    <td><?php echo isset($val->taxable_price) ? $val->taxable_price : ' ' ?></td>
                                    <td><?php echo isset($val->discount) ? $val->discount : ' ' ?></td>
                                    <td><?php echo isset($val->grand_total) ? $val->grand_total : ' ' ?></td>
                                    <td><?php echo isset($val->balance) ? $val->balance : ' ' ?></td>
                                    <td><?php echo isset($val->collected) ? $val->collected : ' ' ?></td>
                                    <?php
                                    $invoice_date = date("d-m-Y", strtotime($val->created_at));
                                    ?>
                                    <td><?php echo isset($invoice_date) ? $invoice_date : ' ' ?></td>
                                    <td><?php $cusid = App\Models\customer::where('active', '1')->where('id', $val->customerID)->first();
                                        echo isset($cusid->phone_number) ? $cusid->phone_number : '- ';
                                        ?></td>
                                        <td><a href="<?php echo $val->invoice_path; ?>" style='text-decoration:none;color:black' target="_blank"><button class="btn btn-info">Invoice</button></a></td>
                                        
                                    <?php
                                    if ($val->balance != 0) {   ?>
                                        <td><a href="/payment/<?php echo $val->id; ?>" style='text-decoration:none;color:black'><button class="btn btn-warning">Payment</button></a></td>
                                    <?php
                                    } else {  ?>
                                        <td>-</td>
                                    <?php   }  ?>
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
        $('#datatable').dataTable( {
      "ordering": false
    } );
    });
  
    $('#invoice').on('change', function() {
        id = $(this).val();
        $("#form_submit").submit();

    })
</script>
@endsection