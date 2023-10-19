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
                    <h3 class="card-title">Purchase Report</h3>
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
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary submit">Filter</button>
                                </div>
                                <div class="form-group">
                                    <a href="/total_purchase">
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
                                    <th>PO.No</th>
                                    <th>product</th>
                                    <th>serial</th>
                                    <th>pur.Date</th>
                                    <th>hsn</th>
                                    <th>Pur. Price</th>
                                    <th>Sell. Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                 $stock_in=0;
                                 $stock_out=0;
                                 $pur_price=0;
                                ?>
                              
                                
                                @foreach($datatable as $key=>$val)
                                <?php
                                 if($val->type==0){
                                    $stock_in+=1;
                                 }else{
                                    $stock_out+=1;
                                 }
                                $pur_price += $val->purchase_price;
                                ?>
                                @if($val->serial != null)
                                <tr>
                                    <td>{{$val->po_no}}</td>
                                    <td>{{$val->category_name}} / {{$val->brand_name}} / {{$val->productName}} </td>
                                    <td>{{$val->serial}}</td>
                                    <?php
                                    $purchasedate = date("d-m-Y", strtotime($val->purchaseDate));
                                    ?>
                                    <td>{{$purchasedate}}</td>
                                    <td>{{$val->hsn}}</td>
                                    <td align='right'>{{number_format($val->purchase_price,2)}}</td>
                                    <td align='right'>{{number_format($val->selling_price,2)}}</td>
                                      <!--<td>
                                        <a target="_blank"  href="{{route('purchase.purchase_print', $val->po_no)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
                                        <a href="{{route('purchase.purchase_edit', $val->po_no)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                        <i class="fa fa-trash delete_modall"  id="{{$val->po_no}}" style="font-size:22px;color:red"></i>
                                    </td> -->
                                </tr>
                                @else
                                <tr style="background-color: antiquewhite;">
                                    <td>{{$val->po_no}}</td>
                                    <td>{{$val->category_name}} / {{$val->brand_name}} / {{$val->productName}}  ({{$val->count}})</td>
                                    <td>--</td>
                                    <?php
                                    $purchasedate = date("d-m-Y", strtotime($val->purchaseDate));
                                    ?>
                                    <td>{{$purchasedate}}</td>
                                    <td>{{$val->hsn}}</td>
                                    <td align='right'>{{number_format($val->purchase_price,2)}}</td>
                                    <td align='right'>{{number_format($val->selling_price,2)}}</td>
                                      <!--<td>
                                        <a target="_blank"  href="{{route('purchase.purchase_print', $val->po_no)}}"><i class="fa fa-print" aria-hidden="true" style="font-size:22px;color:black"></i></a>
                                        <a href="{{route('purchase.purchase_edit', $val->po_no)}}"><i class="fa fa-edit" style="font-size:22px;color:blue"></i></a>
                                        <i class="fa fa-trash delete_modall"  id="{{$val->po_no}}" style="font-size:22px;color:red"></i>
                                    </td> -->
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="row pt-4">
                        <div class="card border-left-primary shadow h-100 bg-dark bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Stock In</h6>
                                        <strong class='text-white'><?= $stock_in; ?></strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Stock Out </h6>
                                        <strong class='text-white'><?= $stock_out; ?></strong>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class='report-count'>Total Purchased Price</h6>
                                        <strong class='text-white'><?= number_format($pur_price,2); ?></strong>
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