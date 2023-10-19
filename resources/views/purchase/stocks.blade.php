@extends('layouts.app')

@section('content')
<style>
    .select2-dropdown{
    z-index: 3051;
}
</style>

<div class="content-wrapper">
			<div class="content container">
				<!--START PAGE HEADER -->

				<section class="page-content mt-6 ">
                <div class="mt-8">
                @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
                @endif
                </div>
						<div class="row">
							<div class="col-12">
								<div class="card">
                                    <div class="card-header   d-flex align-items-center">
                                    <h5 class="">Local Stock List</h5>
                                   </div>
									<div class="card-body">
                                    <div class="row">
                                    <div class="row pb-5">

                                    <table id="datatable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>PO.No</th>
                                                    <th>Company Name</th>
                                                    <th>Pur. Date</th>
                                                    <th>Product Name</th>
                                                    <th>Qty</th>
                                                    <th>Model Name</th>
                                                    <th>Serial Number</th>
                                                    <th>Company</th>
                                                    <th>Rack Location</th>
                                                    <th>Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $val)
                                                <tr>
                                                    <td>{{$val->invoiceID}}</td>
                                                    <td>{{$val->purchase_company}}</td>
                                                    <?php
                                                    $purchasedate = date("d-m-Y", strtotime($val->purchaseDate));
                                                    ?>
                                                    <td>{{$purchasedate}}</td>
                                                    <td>{{$val->product_name}}</td>
                                                    <td>{{$val->qty}}</td>
                                                    <td>{{$val->model}}</td>
                                                    <td>{{$val->serial}}</td>
                                                    @if($val->locationStatus == 1)
                                                    <td>{{$val->bCompany}}</td>
                                                    <td>{{$val->rack_location}}</td>
                                                     @else
                                                    <td>-</td>
                                                    <td>-</td>
                                                       @endif 
                                                    {{-- @if($val->locationStatus == 0)  --}}
                                                        <td><button id="{{$val->p_id}}" value="edit" onclick="openodel(this)" data-info="{{$val->p_id}}" class="btn btn-primary"><i class="fa fa-edit"></i> </button></td>
                                                      {{-- @else
                                                      <td>-</td>
                                                        @endif --}}

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>


                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Edit</h4>
                                <button class="btn-close" data-bs-dismiss="modal" onclick="closeodel()" aria-label="Close">
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="categoryForm" method="post" action="{{ route('purchase.addBranchAndLocation') }}">
                                    @csrf
                                    <input type="hidden" id='id' name='id'>
                            
                
                                    <div class="row">
                                        <input type="text" hidden id="change_id">
                                        <div class="col-md-12">
                                            <label for="">Select Company<span class="error">*</span></label>
                                            <div class="form-group mt-2">
                                                <select  id='branch' class="form-select txt-num  @error('active') is-invalid @enderror" value="" name="company" data-width="100%">
                                                    <option value="">--Select--</option>
                                                 </select>                                                
                                                 @error('branch')
                                                <div class="error">* The Company is required.</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="">Select Rack Location<span class="error">*</span></label>
                                            <div class="form-group">
                                                <select  id='rack' class="form-select txt-num  @error('active') is-invalid @enderror" value="" name="rack"   data-width="100%">
                                                   <option value="">--Select--</option>
                                                </select>
                                                @error('rack')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                            </div>
                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <button type="submit" style="margin-left: 0px;" class="btn  btn-success ">Save </button>
                                            {{-- <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Modal footer -->
                        </div>
                    </div>
                </div>





<script>


 
    function openodel(button) {
        var id = $(button).data('info');
        // alert(id);
    
            $('#myModal').modal('show');



            $.ajax({
                url: '{{route("get.branchAndRack")}}',
                type: 'POST',
                data: {
                    // id: val,
                    "_token": "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    $('body').css('cursor', 'progress');
                },

            
                success: function(data) {
                    // alert('ok');
                    console.log(data);
                   $("#branch").empty();
                   $("#rack").empty();

                    var select = $('#branch'); 
                    var select2 = $('#rack'); 
                    $('#id').val(id);
                  

                    select.append($('<option>', {
                    value: "", 
                    text: "--select--"  
                    }));

                    select2.append($('<option>', {
                    value: "", 
                    text: "--select--" 
                    }));

                    // console.log(data.data.branch);
                    $.each(data.data.company, function(index, item) {
                    
                    var option = $('<option>', {
                    value: item.id, 
                    text: item.company  
                    });

                 
                    select.append(option);
                    });

                    $.each(data.data.rack, function(index, item) {
                    
                    var option2 = $('<option>', {
                    value: item.id, 
                    text: item.rack_location  
                    });


                    select2.append(option2);
                    });

                },
                async: false
            });


    }

    function closeodel() {
        $('#myModal').modal('hide');
    }


</script>



@endsection