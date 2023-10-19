@extends('layouts.app')

@section('content')


<section class="page-content mt-5">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
                <h5 class="card-header">Update Sales Price</h5>
                <form id='form' action="{{route('sale.payment.update')}}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="row"> 
                    <?php $customer=App\Models\customer::select('customers.*','cities.name as city_name')->leftjoin('cities','cities.id','=','customers.city')->where('customers.id',$invoice->customerID)->first();
                    // dd($customer);
                    ?>
                
                    <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Name</label>
                                <input type="text" class="form-control" value='{{$customer->name}}'  readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Phone Number</label>
                                <input type="text" class="form-control"   value='{{$customer->phone_number}}' readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">GST</label>
                                <input type="text" class="form-control"  value='{{$customer->gst}}'  readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">CITY</label>
                                <input type="text" class="form-control"  value='{{$customer->city_name}}'  readonly>
                            </div>
                </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Balance Amount</label>
                                <input type="text" class="form-control @error('balance') is-invalid @enderror" name="balance" readonly="" value="{{$invoice->balance}}">
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
                                <input type="number" class="form-control @error('collected') is-invalid @enderror" name="collected" min=" " max="{{$invoice->balance}}">
                                <input type="hidden" class="form-control" name="invoiceID" value="{{$invoice->id}}">
                                <input type="hidden" class="form-control" name="rentID" value="{{$invoice->grand_total}}">
                                <input type="hidden" class="form-control" name="amount" value="{{$invoice->grand_total}}">
                                <input type="hidden" class="form-control" name="advance" value="{{$invoice->collected}}">
                                @error('collected')
                                <div class="error">*{{$message}}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Select Payment Mode<span class="error">*</span></label>
                                <div class="form-group">
                                    <select id='mop'
                                        class="selectDrop form-select category  @error('mop') is-invalid @enderror"
                                         name="mop">
                                        <option value=""> --Select--</option>
                                        @foreach ($payment as $val)
                                            <option value="{{ $val->id }}">{{ $val->payment_mode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Remarks</label>
                                <textarea style="height:45px" class="form-control" id="remarks" name="remarks" rows="3"></textarea>
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
<section class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Payment Histories</h5>
                <div class="card-body">
                    <table id="datatable" class="table table-striped " style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Received Amount</th>
                                <th>Balance Amount</th>
                                <th>Paid Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_history as $key=>$pay)
                            <tr>
                                <td>{{$key+1}}</td>
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
                mop: 'required',
                collected: {
                    required:true,
                }
            },
            messages: {
                paymentDate: 'This Received Date is required',
                mop: 'This Payment Mode  is required',
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