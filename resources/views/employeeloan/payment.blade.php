@extends('layouts.app')

@section('content')


<section class="page-content mt-5">
    @if ($data->payment_status =='0')
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
                <h5 class="card-header">Update Payment</h5>
                <form id='form' action="{{route('employee.loan.update')}}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="row"> 
                
                    <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Name</label>
                                <input type="text" class="form-control" value='{{$data->first_name}}'  readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Phone Number</label>
                                <input type="text" class="form-control"   value='{{$data->mobile}}' readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">EmailID</label>
                                <input type="text" class="form-control"   value='{{$data->email}}' readonly>
                            </div>
                    </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Balance Amount</label>
                                <input type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" readonly="" value="{{$data->advanceAmount}}">
                                @error('balance')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Received Date<span class="error">*</span></label>
                                <input type="date" class="form-control " name="paymentDate" max=<?= date("Y-m-d");  ?>>
                                @error('paymentDate')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="collected">Collected Amount<span class="error">*</span></label>
                                <input type="number" class="form-control @error('collected') is-invalid @enderror" name="collected" min="{{$data->balance}}" max="{{$data->balance}}">
                                <input type="hidden" class="form-control" name="invoiceID" value="{{$data->id}}">
                                @error('collected')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                      <a href="/viewinoice" class="btn btn-primary">
                        Back
                        </a> 
                        <button class="btn btn-success" type="submit" name="paymentUpdate">Update Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   

</section>
@else
<section class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Payment Histories</h5>
                <div class="card-body">
                    <table id="datatable" class="table table-striped " style="width:100%">
                        <thead>
                            <tr>
                                <th>Received Amount</th>
                                <th>Balance Amount</th>
                                <th>Paid Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_history as $key=>$pay)
                            <tr>
                                <td>{{$pay->collected}}</td>
                                <td>{{$pay->balance}}</td>
                                <?php
                                $paymentDate = date("d-m-Y", strtotime($pay->paymentDate));
                                ?>
                                <td>{{$paymentDate}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
@endif
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