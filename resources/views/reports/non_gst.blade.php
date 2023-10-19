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
                    <h3 class="card-title">Non GST Report</h3>
                </div>

                <div class="card-body">
                    <form action="" id='filter'>
                        <div class="row">
                            <?php
                    // echo $start_date;
                            // $now = date('Y-m-d');
                            // $start_date = date('Y-m-d', strtotime($now . ' -1 month'));
                            ?>
                            <div class="col-md-4">
                                <label for="">From Date</label>
                                <div class="form-group">
                                    <input type="date" value="<?= $start_date; ?>" id='start' placeholder="Enter Serial Number" name='start' class="form-control  @error('price') is-invalid @enderror " required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">To Date</label>

                                <div class="form-group">
                                    <input type="date" id='end' value="<?= $end_date; ?>" placeholder="Enter Serial Number" name='end' class="form-control  @error('price') is-invalid @enderror " required />
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <div class="form-group mr-1">
                                    <button type="submit" class="btn btn-primary submit">Filter</button>
                                </div>
                                <div class="form-group">
                                    <a href="/non-gst-report">
                                        <button type="button" class="btn btn-warning submit">Reset</button>
                                    </a>
                                </div>
                            </div>



                        </div>
                    </form>
                    <div class="row">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Tax.price</th>
                                    <th>Disc</th>
                                    <th>Gra.price</th>
                                    <th>Bal</th>
                                    <th>Received</th>

                                    <th>Phone</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $bill = 0;
                                $amount = 0;
                                $balance = 0;
                                ?>
                                @foreach($datatable as $key=>$val)
                                <?php $bill = $key; ?>
                                <tr>
                                    <td><?php echo isset($val->invoiceID) ? $val->invoiceID : ' '; ?></td>
                                    <td><?php $cusid = App\Models\customer::where('active', '1')->where('id', $val->customerID)->first();
                                        echo isset($cusid->name) ? $cusid->name : " ";
                                        ?></td>

                                    <td><?php echo isset($val->taxable_price) ? $val->taxable_price : ' ' ?></td>
                                    <td><?php echo isset($val->discount) ? $val->discount : ' ' ?></td>
                                    <td><?php echo isset($val->grand_total) ? $val->grand_total : ' ' ?></td>
                                    <td><?php
                                        $balance += $val->balance;
                                        echo isset($val->balance) ? $val->balance : ' ' ?></td>
                                    <td><?php
                                        $amount += $val->collected;
                                        echo isset($val->collected) ? $val->collected : ' ' ?></td>

                                    <td><?php $cusid = App\Models\customer::where('active', '1')->where('id', $val->customerID)->first();
                                        echo isset($cusid->phone_number) ? $cusid->phone_number : '- ';
                                        ?></td>
                                    <!-- <td> <a href="edit-invoice.php?id={$row['id']}&cusID={$row['customerID']}&tax={$row['tax']}"><i class="zmdi zmdi-edit zmdi-hc-fw" style="color:blue;"></i></a></td> -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row pt-4">
                        <div class="card border-left-primary shadow h-100 bg-dark bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Total Bill</h6>
                                        <strong class='text-white'><?= $bill; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Total Amount</h6>
                                        <strong class='text-white'><?= $amount; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Collected</h6>
                                        <strong class='text-white'><?= $amount; ?></strong>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h6 class='report-count'>Outstanding</h6>
                                        <strong class='text-white'><?= $balance; ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    // $('.submit').on('click', function() {
    // alert('hi');
    $('form[id="filter"]').validate({
        rules: {
            start: 'required',
            end: 'required',
        },
        messages: {
            start: 'This From Date is required',
            end: 'This To Date is required',

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
    // id = $(this).val();

    // });
</script>
@endsection