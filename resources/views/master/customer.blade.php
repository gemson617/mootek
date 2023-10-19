@extends('layouts.app')

@section('content')
<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/ ?>
            <div class="row pb-5">

                <div class="col-sm-12">
                    <div class="card border-left-primary shadow h-100 ">
                        <div class="card-header">
                            <h3 class="card-title">Add Customer</h3>
                        </div>
                       
                        <div class="card-body">

                            @if (session('msg'))
                            <div class="alert alert-success" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif 
                       {{-- @php
                       $decodedData = json_decode($cus_draft);
                       $json = $decodedData && isset($decodedData->data) ? json_decode($decodedData->data) : '';
                   @endphp --}}
    
                   
                            <form id="form" method="post" action="{{route('customer.cus_store')}}">
                                @csrf
                                <input type="hidden" id='id' name='id'>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Customer Category<span class="error">*</span></label>
                                        <div class="form-group">

                                            <select class="form-select txt-num cat  @error('cus_category_id') is-invalid @enderror data-input cus_category_id" id='cus_category_id' name="cus_category_id">
                                                <option value="">--Select--</option>
                                                @foreach($customer_category as $val)
                                                <option value="{{$val->id}}" <?= isset($json->cus_category_id)?($val->id==$json->cus_category_id?'selected':''):'';?>>{{$val->category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Sub Category<span class="error">*</span></label>
                                        <div class="form-group">

                                            <select class="form-select txt-num  @error('cus_sub_category_id') is-invalid @enderror data-input cus_sub_category_id" id='cus_sub_category_id' name="cus_sub_category_id">
                                                <option value="">--Select--</option>
                                                @foreach($customer_sub_category as $val)
                                                <option value="{{$val->id}}"  <?= isset($json->cus_sub_category_id)?($val->id==$json->cus_sub_category_id?'selected':''):''; ?>>{{$val->sub_category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">  Vendor<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='vendor' value="<?=isset($json->vendor)?$json->vendor:'VENR'.count($data)+1;  ?>" class="form-control  @error('vendor') is-invalid @enderror data-input" placeholder=" Vendor" name="vendor" />
                                            @error('vendor')
                                            <div class="error">*The Customers Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 supplierCodeClass">
                                        <label for="">Supplier Code<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='supplier_code' class="form-control  @error('supplier_code') is-invalid @enderror data-input" value="<?=isset($json->supplier_code)?$json->supplier_code:'';  ?>" placeholder=" Supplier Code" name="supplier_code" />
                                            @error('supplier_code')
                                            <div class="error">*The Customers Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2 type">
                                        <label for="">Type <span class="error">*</span></label>
                                        <select class="form-select txt-num  @error('type') is-invalid @enderror data-input type" id='type' name="type">
                                            {{-- <option value="" >--Select--</option> --}}

                                            <option value="company" >Company</option>
                                            <option value="individual" >Individual</option>

                                        </select>
                                    </div>

                                    <div class="col-md-1 hideIndividual" id='sal_company'>
                                        <label for="" id='sal_company'>Salutation</label>
                                        <select id='sal_company' class="form-select txt-num  @error('sal_company') is-invalid @enderror data-input sal_company"  name="sal_company">
                                            @foreach($salutation as $val)
                                            <option value="{{$val->id}}" >{{$val->salutation_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 hideIndividual" id='company' >
                                        <label for="">Company Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='company' class="form-control  @error('company') is-invalid @enderror data-input" value="<?=isset($json->company)?$json->company:'';  ?>" placeholder=" Company Name" name="company" />
                                            @error('company')
                                            <div class="error">*The Customers Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-md-1 hideIndividual" id='sal_billing'>
                                        <label for="">Salutation</label>
                                        <select id='sal_billing' class="form-select txt-num  @error('sal_billing') is-invalid @enderror data-input sal_billing"  name="sal_billing">

                                            @foreach($salutation as $val)
                                            <option value="{{$val->id}}" >{{$val->salutation_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 hideIndividual" id="billing_name">
                                        <label for="" >Billing Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='billing_name' class="form-control  @error('billing_name') is-invalid @enderror data-input" value="<?=isset($json->billing_name)?$json->billing_name:'';  ?>" placeholder=" Company Name" name="billing_name" />
                                            @error('billing_name')
                                            <div class="error">*The Customers Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <label for="">Salutation</label>
                                        <select class="form-select txt-num  @error('sal_customer') is-invalid @enderror data-input sal_customer" id='sal_customer' name="sal_customer">
                                            @foreach($salutation as $val)
                                            <option value="{{$val->id}}" >{{$val->salutation_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">Name<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='name' style="text-transform:uppercase" class="form-control  @error('name') is-invalid @enderror data-input" value="<?=isset($json->name)?$json->name:'';  ?>" placeholder=" Name" name="name" />
                                            @error('name')
                                            <div class="error">*The Customers Name field is required.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Email<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="email" id='email' style="text-transform:lowercase" class="form-control  @error('email') is-invalid @enderror data-input" value="<?=isset($json->email)?$json->email:'';  ?>"  placeholder=" Email" name="email" />
                                            @error('email')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Mobile<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input  type="number" id='mobile' class="form-control  @error('mobile') is-invalid @enderror data-input" placeholder=" Mobile" value="<?=isset($json->mobile)?$json->mobile:'';  ?>" name="mobile" />
                                            @error('mobile')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Billing Address<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='billing_address' class="form-control  @error('billing_address') is-invalid @enderror data-input" value="<?=isset($json->billing_address)?$json->billing_address:'';  ?>" placeholder=" Billing Address" name="billing_address" />
                                            @error('billing_address')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Select State<span class="error"> * </span> <a class="fa fa-plus-circle" href="/state"></a></label>
                                        <div class="form-group">

                                            <select class="form-select txt-num  @error('billing_state') is-invalid @enderror data-input state"  onchange="get_b_city(this.value,'');" id='billing_state' name="billing_state">
                                                <option value="">--Select--</option>
                                                @foreach($states as $val)
                                                <option value="{{$val->id}}" <?=isset($json->billing_state)?($json->billing_state==$val->id?'selected':''):'';  ?> >{{$val->state_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('state')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for=""> City<span class="error"> * </span> <a class="fa fa-plus-circle" href="/city"></a></label>

                                        <div class="form-group">
                                            <select class="form-select txt-num  @error('billing_city') is-invalid @enderror data-input billing_city" id='billing_city' name="billing_city">
                                                <option value="">--Select--</option>
                                                {{-- @foreach($cities as $val)
                                                <option value="{{$val->id}}" >{{$val->name}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        @error('city')
                                        <div class="error">*{{$message}}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-2">
                                        <label for="">Pincode<span class="error">*</span></label>
                                        <div class="form-group">
                                            <input type="number" id='billing_pincode' class="form-control  @error('billing_pincode') is-invalid @enderror data-input"  value="<?=isset($json->billing_pincode)?$json->billing_pincode:'';  ?>" placeholder=" Pincode" name="billing_pincode" />
                                            @error('billing_pincode')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Email ID<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='alternative_emailID' class="form-control  @error('alternative_emailID') is-invalid @enderror data-input" value="<?=isset($json->alternative_emailID)?$json->alternative_emailID:'';  ?>" placeholder=" EmailID" name="alternative_emailID" />
                                            @error('alternative_emailID')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 hideIndividual">
                                        <label for="" id="gst">GST<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='gst' class="form-control  @error('gst') is-invalid @enderror data-input" placeholder=" GST" value="<?=isset($json->gst)?$json->gst:'';  ?>" name="gst" />
                                            @error('gst')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">PAN<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='pan' style="text-transform:uppercase" class="form-control  @error('pan') is-invalid @enderror data-input" value="<?=isset($json->pan)?$json->pan:'';  ?>" placeholder="PAN" name="pan" />
                                            @error('pan')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 hideIndividual">
                                        <label for="" id="tan">TAN<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='tan' class="form-control  @error('tan') is-invalid @enderror data-input" placeholder="TAN" name="tan" value="<?=isset($json->tan)?$json->tan:'';  ?>" />
                                            @error('tan')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">ID NO<span class="error">*</span></label>

                                        <div class="form-group">
                                            <input type="Text" id='id_no' class="form-control  @error('id_no') is-invalid @enderror data-input" placeholder="ID NO" name="id_no" value="<?=isset($json->id_no)?$json->id_no:'';  ?>" />
                                            @error('id_no')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="max">
                                        <div class="addaddress" id="deliverAddress">
                                             <div class="row">
                                                <div class="col-md-3 count1">
                                                    <label for="">Company Name<span class="error">*</span></label>
                                                    <div class="form-group">
                                                        <input type="Text" id='companyName' class="form-control  @error('companyName') is-invalid @enderror data-input" placeholder="Company Name"  name="companyName[]" />
                                                        @error('companyName')
                                                        <div class="error">*{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2 count1">
                                                    <label for="">Delivery Address<span class="error">*</span></label>
                                                    <div class="form-group">
                                                        <input type="Text" id='d_address0' class="form-control  @error('d_address') is-invalid @enderror data-input" placeholder="Delivery Address"  name="d_address[]" />
                                                        @error('d_address')
                                                        <div class="error">*{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Select State<span class="error"> * </span> <a class="fa fa-plus-circle" href="/state"></a></label>
                                                    <div class="form-group">
            
                                                        <select class="form-select txt-num  @error('state') is-invalid @enderror data-input state" onchange="get_city(this.value,'0');" id='state' name="state[]">
                                                            <option value="">--Select--</option>
                                                            @foreach($states as $val)
                                                            <option value="{{$val->id}}" >{{$val->state_name}}</option>
                                                            @endforeach
                                                        </select>
            
                                                        @error('state')
                                                        <div class="error">*{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>
            
                                                <div class="col-md-2">
                                                    <label for="">Select City<span class="error"> * </span> <a class="fa fa-plus-circle" href="/city"></a></label>
            
                                                    <div class="form-group">
                                                        <select class="form-select txt-num  @error('city') is-invalid @enderror data-input city" id='city0' name="city[]">
                                                            <option value="">--Select--</option>
                                                      
                                                        </select>
                                                    </div>
                                                    @error('city')
                                                    <div class="error">*{{$message}}</div>
                                                    @enderror
                                                </div>
            
            
                                                <div class="col-md-2">
                                                    <label for="">Pincode<span class="error">*</span></label>
                                                    <div class="form-group">
                                                        <input type="number" id='pincode' class="form-control  @error('pincode') is-invalid @enderror data-input" placeholder=" Pincode" name="pincode[]" />
                                                        @error('pincode')
                                                        <div class="error">*{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                             </div>
                                        </div>
                                        <div class="col-md-1 mt-3" id="addbuttons"><br>
                                            <button type="button" id="button1" class="add-field btn btn-success btn-circle"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-3 ml-4 ml-5 mb-3">
                                        <label>
                                            <input type="checkbox" id="addressCheck" class="form-check-input" name="s_check"  >Shipping Address Same as Billing Address
                                          </label>
                                    </div>
                        
                                </div>
                                 <div class="row">
                                            <h6>Purchase Department</h6>
                                    <div class="col-md-4">
                                        <label for="">Name</label>
                                        <div class="form-group">
                                            <input type="text" id='purchase_name' style="text-transform:uppercase" class="form-control  @error('purchase_name') is-invalid @enderror data-input" placeholder="name"  value="<?=isset($json->purchase_name)?$json->purchase_name:'';  ?>" name="purchase_name" />
                                            @error('purchase_name')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Contact No</label>
                                        <div class="form-group">
                                            <input type="number" id='purchase_contact' class="form-control  @error('purchase_contact') is-invalid @enderror data-input" placeholder="Enter Contact No" value="<?=isset($json->purchase_contact)?$json->purchase_contact:'';  ?>" name="purchase_contact" />
                                            @error('purchase_contact')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Email</label>
                                        <div class="form-group">
                                            <input type="email" id='purchase_email' style="text-transform:lowercase" class="form-control  @error('purchase_email') is-invalid @enderror data-input" placeholder="Email" value="<?=isset($json->purchase_email)?$json->purchase_email:'';  ?>" name="purchase_email" />
                                            @error('purchase_email')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                 </div>

                                    <div class="row">
                                        <h6>Accounts Department</h6>
                                        <div class="col-md-3">
                                            <label for="">Name<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="text" id='account_name' style="text-transform:uppercase" class="form-control  @error('account_name') is-invalid @enderror data-input" placeholder="Name"  value="<?=isset($json->account_name)?$json->account_name:'';  ?>" name="account_name" />
                                                @error('account_name')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
    
                                        <div class="col-md-3">
                                            <label for="">Contact No<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="number" id='account_contact' class="form-control  @error('account_contact') is-invalid @enderror data-input" placeholder="Enter Contact No" value="<?=isset($json->account_contact)?$json->account_contact:'';  ?>" name="account_contact" />
                                                @error('account_contact')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
    
                                       
                                        <div class="col-md-3">
                                            <label for="">Email<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="email" id='account_email' style="text-transform:lowercase" class="form-control  @error('account_email') is-invalid @enderror data-input" placeholder="Enter Email" value="<?=isset($json->account_email)?$json->account_email:'';  ?>" name="account_email" />
                                                @error('account_email')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Landline<span class="error">*</span></label>
                                            <div class="form-group">
                                                <input type="number" id='landline' class="form-control  @error('landline') is-invalid @enderror data-input" placeholder="Enter Landline" value="<?=isset($json->landline)?$json->landline:'';  ?>" name="landline" />
                                                @error('landline')
                                                <div class="error">*{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for=""> Sales Executive<span class="error">*</span><a class="fa fa-plus-circle" href="/employee"></a></label>
    
                                            <div class="form-group">
                                                <select class="form-select txt-num  @error('sale_executive') is-invalid @enderror data-input sale_executive" id='sale_executive'  name="sale_executive">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_role as $val)
                                                    <option value="{{$val->id}}"  <?=isset($json->sale_executive)?($json->sale_executive==$val->id?'selected':''):'';  ?>>{{$val->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Relationship Manager<span class="error">*</span><a class="fa fa-plus-circle" href="/employee"></a></label>
    
                                            <div class="form-group">
                                                <select class="form-select txt-num  @error('relationship_manager') is-invalid @enderror data-input relationship_manager" id='relationship_manager' name="relationship_manager">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_role as $val)
                                                    <option value="{{$val->id}}" <?=isset($json->relationship_manager)?($json->relationship_manager==$val->id?'selected':''):'';  ?> >{{$val->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for=""> Tech Executive<span class="error">*</span><a class="fa fa-plus-circle" href="/employee"></a></label>
    
                                            <div class="form-group">
                                                <select class="form-select txt-num  @error('tech_engg') is-invalid @enderror data-input tech_engg" id='tech_engg' name="tech_engg">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_role as $val)
                                                    <option value="{{$val->id}}" <?=isset($json->tech_engg)?($json->tech_engg==$val->id?'selected':''):'';  ?>>{{$val->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Tech Manager<span class="error">*</span><a class="fa fa-plus-circle" href="/employee"></a></label>
    
                                            <div class="form-group">
                                                <select class="form-select txt-num  @error('tech_manager') is-invalid @enderror data-input tech_manager" id='tech_manager' name="tech_manager" >
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_role as $val)
                                                    <option value="{{$val->id}}" <?=isset($json->tech_manager)?($json->tech_manager==$val->id?'selected':''):'';  ?>>{{$val->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('city')
                                            <div class="error">*{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="/master-menus" class="btn btn-sm btn-primary mr-1 cancel">Back</a>
                                        <button type="submit" class="btn btn-sm btn-success mr-1">Submit</button>
                                        <a href="#" class="btn btn-sm btn-danger mr-1 cancel">Cancel</a>
                                        
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>



            <div class="row pb-5">
                <table id="datatable" class='table'>
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Moblie</th>
                            <th>Entry Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <!-- <td>{{$val->id}}</td> -->
                            <td>{{$val->name}}</td>
                            <td>{{$val->company}}</td>
                            <td>{{$val->mobile}}</td>
                            <?php
                            $entry = date("d-m-Y", strtotime($val->created_at));
                            ?>
                            <td>{{$entry}}</td>
                            <td><?= $val->status?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">In Active</span>'?></td>                               
                            <td><a href="javascript:void(0)" data="<?= $val->id ?>" class="btn btn-primary edit_form"><i class="fa fa-edit"></i></a>
                                <button value='{{$val->id}}' data="{{$val->status}}" data-name="customer" class='btn btn-info change'>status</button>

                            </td>
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
</div>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>


        $(document).ready(function () {


            $("#type").change(function() {

            type = $("#type").val();
            if(type === 'individual'){
                $(".hideIndividual").addClass("d-none");
            }else
            { 
                $(".hideIndividual").removeClass("d-none");
            }

            });
           
            $("#addressCheck").change(function() {

                if (this.checked) {
                    $("#deliverAddress").addClass("d-none");
                }else{
                    $("#deliverAddress").removeClass("d-none");
                }
            });

            






  $(window).on('load', function () {
    $('.cat').focus().select2();
  });
});
    $(".form-check-input").click(function() {
            // Toggle the checked state of the checkbox
            // $(this).prop("checked", !$(this).prop("checked"));
        if ($(this).prop("checked")) {
        $(".s_address").addClass("d-none");

        } else {
        // Checkbox is not checked
        // Your code here
        $(".s_address").removeClass("d-none");

         $("#state1").select2();
         $("#country1").select2();
         $("#city1").select2();

        }
        });
        function removediv(no){
            $('.field'+no).remove();
            // var id = $('#id'+no).val();
            // var $wrapper = $('#removefield');
            // var row = $('<input type="hidden" id="removeid" name="removeid[]" value="'+id+'">');
            // row.appendTo($wrapper);
            // calculateAmount();
        }
    
    $('form[id="form"]').validate({
        rules: {
            cus_category_id: 'required',
            cus_sub_category_id: 'required',
            vendor: 'required',
            supplier_code: 'required',
            company: {
                    required: true,
                    remote: {
                        url: "{{route('exit.index') }}", // Laravel route for email validation
                        type: "post", // HTTP request method
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token
                            name: function () {
                                return $("#company").val();
                            },
                            id: function () {
                                 return $("#id").val(); // Replace with the actual input ID
                            },
                            table: function () {
                                 return 'customer'; // Replace with the actual input ID
                            },
                            column: function () {
                                 return 'company'; // Replace with the actual input ID
                            },
                        },
                     },
                     },
            billing_name: 'required',
            name: 'required',
            email: {
            required: true,
            email: true
            },
            mobile: {
           required: true,
            number: true, // This rule ensures that the input is a valid number
            pattern:/^[0-9]{10}$/
           },
            billing_address: 'required',
            billing_state: 'required',
            billing_city: 'required',
            billing_pincode: {
                required: true,
                billing_pincode:true
            },
            alternative_emailID: {
            required: true,
            email: true
            },
            gst: {
            required: true,
            gstLength:true
            },
            pan: {
             required: true,
            pattern: /^[A-Z]{5}[0-9]{4}[A-Z]$/ // Regular expression pattern for alphanumeric input
            },
            tan: 'required',
            id_no: 'required',
            'd_address[]': 'required',
            'state[]': 'required',
            'city[]': 'required',
            'pincode[]': {
                required: true,
                billing_pincode:true
            },

        //     purchase_name: 'required',
        //     purchase_contact: {
        //   required: true,
        //   number: true, // This rule ensures that the input is a valid number
        //   pattern:/^[0-9]{10}$/
        //    },
            // purchase_email: {
            // required: true,
            // email: true
            // },
            account_name: 'required',
            account_contact: {
          required: true,
          number: true, // This rule ensures that the input is a valid number
          pattern:/^[0-9]{10}$/

           },
            account_email: {
            required: true,
            email: true
            },
            landline: {
            required: true,
            number: true
            },
            sale_executive: 'required',
            relationship_manager: 'required',
            tech_engg: 'required',
            tech_manager: 'required',
        },
        messages: {
            cus_category_id: 'This  Customer Category  is Required',
            cus_sub_category_id: 'This  Sub Category  is Required',
            vendor: 'This  Vendor  is Required',
            supplier_code: 'This  Supplier Code  is Required',
            company: {
                    required: "This  Name  is Required",
                    remote: "Company Name already exists",
                },
            billing_name: 'This  Billing Name  is Required',
            name: 'This  Name  is Required',
            email: {
            required:  'This  Email  is Required',
            email: 'Please enter a valid email address'
            },
            mobile: {
            required: 'This  Mobile  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            pattern: "Please Enter 10 Digit Number"
            },
            billing_address: 'This  Billing Address  is Required',
            billing_state: 'This  State  is Required',
            billing_city: 'This  City  is Required',
            alternative_emailID: {
            required: 'This  Email  is Required',
            email: 'Please enter a valid email address',
            },
            gst: {
            required: "GST Number is required.",
            },
            pan: {
          required: "Please enter text.",
          pattern: "Please Enter valid PAN number."
          },
            tan: 'This  TAN  is Required',
            id_no: 'This  ID NO  is Required',
            'd_address[]': 'This  Delivery is required',
            'state[]': 'This  State is required',
            'city[]': 'This  City is required',
            'pincode[]': {
                required : 'This  Pincode is required',
            },

            // purchase_name: 'This  Name  is Required',
            // purchase_contact: {
            // required: 'This  Contact No  is Required',
            // number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            // pattern: "Please Enter 10 Digit Number"
            // },
            // purchase_email: {
            // required: 'This  Email  is Required',
            // email: 'Please enter a valid email address',
            // },
            account_name: 'This  Name  is Required',
            account_contact: {
            required: 'This  Contact No  is Required',
            number: 'Please enter a valid number', // This rule ensures that the input is a valid number
            pattern: "Please Enter 10 Digit Number"
            },
            account_email: {
            required: 'This  Email  is Required',
            email: 'Please enter a valid email address',
            },
            landline: {
            required: 'This  Landline  is Required',
            number: 'Please enter a valid number',
            },
            sale_executive: 'This  Sales Executive  is Required',
            relationship_manager: 'This  Relationship Manager  is Required',
            tech_engg: 'This  Tech Executive  is Required',
            tech_manager: 'This  Tech Manager  is Required',
            phone_number: {
                required:'This Phone Number is required',
                minlength:'Minimum numer 10 is required',
            },
        },
        errorPlacement: function(label, element) {

           label.addClass('mt-2 text-danger');
            if (element.hasClass('form-select') && element.next('.select2-container').length) {
                label.insertAfter(element.next('.select2-container'));
            } else {
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

    $.validator.addMethod("gstLength", function(value, element) {
            return value.length === 15;
        }, "GST must be exactly 15 characters long.");


        $.validator.addMethod("billing_pincode", function(value, element) {
            return value.length === 6;
        }, "Pincode must be exactly 6 characters long.");



//         var form = $("#form");
//         form.validate(validationSettings);

// function draft(){
//     alert('hii');
//     form.validate().resetForm();
// }


        // $(".draft").click(function() {
        //     alert('hii');
        //   console.log('the draft button is clicked');
        //     form.validate().resetForm();
           
        // });



    $.validator.addMethod(
    "gstFormat",
    function (value, element) {
      // Implement your GST validation logic here
      // Example GST format: 12AAACJ1234A1Z8
      var gstRegex = /^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/;
      return this.optional(element) || gstRegex.test(value);
    },
    "Please enter a valid GST Number"
  );

  $.validator.addMethod("alphanumeric", function(value, element) {
      return this.optional(element) || /^[A-Za-z]+$/.test(value);
    }, "Please enter only alphanumeric characters.");

    $(document).ready(function() {

        $('.max').each(function() {
    var $wrapper = $('.addaddress', this);
    $(".add-field", $(this)).click(function(e, no) {
        var no = $('.count1').length;
        var row = $(
            '<div class="row field'+no+'"> <div class="col-md-3 count1"><label for="">Company Name<span class="error">*</span></label><div class="form-group"><input type="text"  id="companyName' +
                    no + '" class="form-control data-input" name="companyName[] " placeholder="Company Name"  required /></div> <div class="mb-2"></div> </div> ' +
                   '<div class="col-md-2 count1"><label for="">Delivery Address<span class="error">*</span></label><div class="form-group"><input type="text"  id="d_address' +
                    no + '" class="form-control data-input" name="d_address[] " placeholder="Delivery Address"  required /></div> <div class="mb-2"></div> </div> ' +
                   '<div class="col-md-2"><label for="">Select State<span class="error">*</span><a class="fa fa-plus-circle" href="/state"></a></label><div class="form-group"><select id="state' + no + '" onchange="get_city(this.value,'+no+');"  name="state[]" class="form-select  selectDrop  data-input"><option value=""> --Select--</option>@foreach ($states as $val)<option value="{{ $val->id }}">{{ $val->state_name }}</option>@endforeach</select></div></div>' +
                   '<div class="col-md-2"><label for="">Select City<span class="error">*</span> <a class="fa fa-plus-circle" href="/city"></a></label><div class="form-group "><select id="city' + no + '" name="city[]" class="form-select  selectDrop  data-input"><option value=""> --Select--</option></select></div></div>' +
                   '<div class="col-md-2"><label for="">Pincode<span class="error">*</span></label><div class="form-group "><input type="text"  id="pincode' +
                    no + '" class="form-control data-input" name="pincode[]" placeholder="Pincode" required /></div> <div class="mb-2"></div> </div> ' +

            '<div class="col-md-1" style="width:4.333333%"><i class="fa fa-trash mt-5" onclick="removediv('+no+')" id="remove'+no+'" style="font-size:22px;color:red"></i></div></div>');
        row.appendTo($wrapper);
        $(".selectDrop").select2();
    });
});

        setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);



        $(".edit_form").click(function() {
            $("#form").load("content.html");
            id = $(this).attr('data');
            $.ajax({
                type: 'get',
                data: {
                    id: id
                },
                url: "{{route('customer.cus_index')}}",
                success: function(data) {

                    type = data.data.type;
                    // alert(type)
                   
                    if(type === 'individual')
                    {
                        $(".hideIndividual").addClass("d-none");
                        // $(".supplierCodeClass").addClass("col-md-4");
                    }else{
                        $(".hideIndividual").removeClass("d-none");

                    }

                    console.log(data.delivery);
                    $("#cus_category_id").val(data.data.cus_category_id).select2();
                    $("#cus_sub_category_id").val(data.data.cus_sub_category_id).select2();
                    $("#vendor").val(data.data.vendor);
                    $("#supplier_code").val(data.data.supplier_code);
                    $("#sal_billing").val(data.data.sal_billing);
                    $("#billing_name").val(data.data.billing_name);
                    $("#vendor").val(data.data.vendor);
                    $("#sal_company").val(data.data.sal_company);
                    $("#company").val(data.data.company);
                    $("#sal_customer").val(data.data.sal_customer);
                    $("#name").val(data.data.name);
                    $("#email").val(data.data.email);
                    $("#mobile").val(data.data.mobile);
                    $("#billing_address").val(data.data.billing_address);
                    $("#alternative_emailID").val(data.data.alternative_emailID);
                    $("#billing_state").val(data.data.billing_state).select2();
                    $("#billing_city").val(data.data.billing_city).select2();
                    $("#billing_pincode").val(data.data.billing_pincode);
                    $("#pincode").val(data.data.pincode);
                    $("#gst").val(data.data.gst);
                    $("#pan").val(data.data.pan);
                    $("#tan").val(data.data.tan);
                    $("#id_no").val(data.data.id_no);
                    $("#purchase_name").val(data.data.purchase_name);
                    $("#purchase_contact").val(data.data.purchase_contact);
                    $("#purchase_email").val(data.data.purchase_email);
                    $("#account_name").val(data.data.account_name);
                    $("#account_contact").val(data.data.account_contact);
                    $("#account_email").val(data.data.account_email);
                    $("#landline").val(data.data.landline);
                    $("#sale_executive").val(data.data.sale_executive).select2();
                    $("#relationship_manager").val(data.data.relationship_manager).select2();
                    $("#tech_engg").val(data.data.tech_engg).select2();
                    $("#tech_manager").val(data.data.tech_manager).select2();
                    // The number of rows you want to add
                    var numberOfRows = data.delivery.length; // Change this to the desired number of rows
                    // The container element where you want to append the rows
                    $(".addaddress").empty();
                    var container = $(".addaddress");
                    for (var i = 0; i < numberOfRows; i++) {
                        // Create a new row
                        var newRow = $(
                            '<div class="row field'+data.delivery[i].id+'" >' +
                                '<div class="col-md-3 count1">' +
                                    '<label for="">Delivery Address</label>' +
                                    '<div class="form-group">' +
                                        '<input type="Text" id="d_address' + i + '" style="text-transform:uppercase" value="'+data.delivery[i].d_address+'" class="form-control" placeholder="d_address" name="d_address[]" />' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-3">' +
                                    '<label for="">Select State</label>' +
                                    '<div class="form-group">' +
                                        '<select class="form-select txt-num   state" onchange="get_city(this.value,' + i + ');" id="state' + i + '" name="state[]">' +
                                            '<option value="">--Select--</option>' +
                                            '@foreach($states as $val)' +
                                            '<option value="{{$val->id}}" '+ (data.delivery[i].state == '{{$val->id}}' ? 'selected' : '') +'>{{$val->state_name}}</option>' +
                                            '@endforeach' +
                                        '</select>' +
                                       
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-2">' +
                                    '<label for="">Select City</label>' +
                                    '<div class="form-group">' +
                                        '<select class="form-select txt-num city" id="city' + i + '" name="city[]">' +
                                            '<option value="">--Select--</option>' +
                                        '</select>' +
                                    '</div>' +
                                    
                                '</div>' +
                                '<div class="col-md-2">' +
                                    '<label for="">Pincode</label>' +
                                    '<div class="form-group">' +
                                        '<input type="text" id="pincode' + i + '" class="form-control"  value="'+data.delivery[i].pincode+'" placeholder="Enter pincode" name="pincode[]" />' +
                                        
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-1">' +
                                    '<i class="fa fa-trash mt-5" onclick="removediv('+data.delivery[i].id+')" id="remove'+data.delivery[i].id+'" style="font-size:22px;color:red"></i>'+
                                '</div>' +
                            '</div>'+
                         '</div>'
                        );
                        // Append the new row to the container
                        container.append(newRow);
                        $('select').select2();
                       

                    }
                    $(".card-title").html('Edit Customer').css('color', 'red');
                    $("#id").val(data.data.id);
                    $(".cat").focus();
                    
                    scrollToTop();
                }
            });
        });
        

        $(".delete_modal").click(function() {

            id = $(this).attr('data');
            $("#delete_id").val(id);
            $("#delete_modal").modal('show');
        });
        $("#delete").click(function() {

            id = $('#delete_id').val();
            $.ajax({
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,

                },
                url: "{{route('customer.cus_delete')}}",
                success: function(data) {
                    $("#delete_modal").modal('hide');
                    document.location.reload();
                }
            });
        });

     



    });
    // $(document).ready(function () {
    //         // Initialize Select2 for select elements with the 'select2-input' class
    //         $('.select2-input').select2();

    //         $('.data-input').on('input change', handleInputChange);

    //         function handleInputChange() {
    //             var jsonData = {};

    //             $('.data-input').each(function () {
    //                 jsonData[$(this).attr('name')] = $(this).val();
    //             });

    //             // Send JSON data to the server using an AJAX request
    //             $.ajax({
    //                 url: '/cus_draft',
    //                 method: 'POST',
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 data: JSON.stringify(jsonData),
    //                 contentType: 'application/json',
    //                 success: function (data) {
    //                     // Handle the response here, e.g., show a success message
    //                     console.log(data.message);
    //                 },
    //                 error: function (error) {
    //                     // Handle any errors, e.g., display an error message
    //                     console.error(error);
    //                 }
    //             });
    //         }
    //     });

</script>
@endsection