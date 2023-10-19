@extends('layouts.app')

@section('content')

@if ($data->payment_status =='0')
<section class="page-content mt-5">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
                <h5 class="card-header">Payment</h5>
                <form id='form' action="{{route('purchase.payment.update')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Description</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks">
                                @error('remarks')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Balance Amount</label>
                                <input type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" readonly="" value="{{$data->balance}}">
                                @error('balance')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Paid Date<span class="error">*</span></label>
                                <input type="date" class="form-control " name="paymentDate" max=<?= date("Y-m-d");  ?>>
                                @error('paymentDate')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="collected">Collected Amount<span class="error">*</span></label>
                                <input type="number" class="form-control @error('collected') is-invalid @enderror" name="collected" max="{{$data->balance}}" required>
                                <input type="hidden" class="form-control" name="invoiceID" value="{{$data->id}}">
                                {{-- <input type="hidden" class="form-control" name="rentID" value="{{$invoice->grand_total}}">
                                <input type="hidden" class="form-control" name="amount" value="{{$invoice->grand_total}}">
                                <input type="hidden" class="form-control" name="advance" value="{{$invoice->collected}}"> --}}
                                @error('collected')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Select Purchase Status<span class="error">*</span></label>
                                <div class="form-group">
                                    <select id='purchase_status'
                                        class="selectDrop form-select category  @error('purchase_status') is-invalid @enderror"
                                         name="purchase_status">
                                        <option value=""> --Select--</option>
                                        @foreach ($payment_status as $val)
                                            <option value="{{ $val->id }}">{{ $val->payment_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Select Bank<span class="error">*</span></label>
                                <div class="form-group">
                                    <select id='bankID'
                                        class="selectDrop form-select category  @error('bankID') is-invalid @enderror"
                                         name="bankID">
                                        <option value=""> --Select--</option>
                                        @foreach ($bank as $val)
                                            <option value="{{ $val->id }}">{{ $val->bank_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Select Purchase Type<span class="error">*</span></label>
                                <div class="form-group">
                                    <select id='purchase_type'
                                        class="selectDrop form-select category  @error('purchase_type') is-invalid @enderror"
                                         name="purchase_type">
                                        <option value=""> --Select--</option>
                                        @foreach ($purchase_mode as $val)
                                            <option value="{{ $val->id }}">{{ $val->purchase_mode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                      <a href="/viewinoice" class="btn btn-primary">
                        Back
                        </a> 
                        <button class="btn btn-success" type="submit">Update Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endif
<section class="page-content mt-5">
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
                                <th>Payment Status</th>
                                <th>Purchase Type</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_histories as $key=>$pay)
                            <tr>
                                <td>{{$pay->collected}}</td>
                                <td>{{$pay->balance}}</td>
                                <?php
                                $paymentDate = date("d-m-Y", strtotime($pay->paymentDate));
                                ?>
                                <td>{{$paymentDate}}</td>
                                <td>{{$pay->payment_status}}</td>
                                <td>{{$pay->purchase_mode}}</td>
                                  
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
                purchase_status: 'required',
                bankID: 'required',
                purchase_type: 'required',
            },
            messages: {
                paymentDate: 'This Paid Date is required',
                purchase_status: 'This Purchase Status is required',
                bankID: 'This bank  is required',
                purchase_type: 'This Purchase Type  is required',
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