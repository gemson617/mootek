@extends('layouts.app')

@section('content')

<section class="page-content mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Loan Histories</h5>
                <div class="card-body">
                    <table id="datatable" class="table table-striped " style="width:100%">
                        <thead>
                            <tr>
                                <th>No Of Month</th>
                                <th>Total Amount</th>
                                <th>Amount </th>
                                <th>Month Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histores as $key=>$pay)
                            <tr>
                                <td>{{$pay->no_month}}</td>
                                <td>{{$pay->total_amount}}</td>
                                <td>{{$pay->amount}}</td>
                                <?php
                                $paymentDate = date("d-m-Y", strtotime($pay->month_date));
                                ?>
                                <td>{{$paymentDate}}</td>
                                <td><?php echo  date("n", strtotime($pay->month_date))==date("m")?'<button class="btn btn-success"><i class="fas fa-check-circle"></i></button>':'<button class="btn btn-danger"><i class="fas fa-clock"></button>'; ?></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {

$('#datatable').DataTable({
    "ordering": false
});
});

$('form[id="form"]').validate({
            ignore: 'input[type=hidden], .select2-input, .select2-focusser',
            rules: {
                paymentDate: 'required',
                collected: {
                    required:true,
                }
            },
            messages: {
                paymentDate: 'This Received Date is required',
                collected: {
                    required:'This collected is required',
                },

            },
            errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger');
                if(element.hasClass('form-select') && element.next('.select2-container').length) {
                label.insertAfter(element.next('.select2-container'));
                }
                else{
                label.insertAfter(element);
                }
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
</script>
@endsection