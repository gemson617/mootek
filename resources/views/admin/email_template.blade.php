@extends('layouts.app')

@section('content')

<div class="app-content page-body">
    <div class="container">
        <div class="">
            <?php /*@include('layouts.partials.menu')*/?>

            <div class="page-header">
                <div class="page-leftheader">
                    <h4 class="page-title">Email Template</h4>
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Email Template</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card border-left-primary shadow h-100 ">
                    <div class="card-header">
                        <h3 class="card-title">Add Email Template</h3>
                    </div>

                    <div class="card-body">

                        @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                        @endforeach
                        @endif

                        @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                        @endif

                        <form method="post" action="{{route('admin.store-template')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Template Name<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="hidden" value="" name="id" id="id" />
                                        <select name="email_template_name" onchange="getTemplate(this.value)" class="form-control">
                                            <option>--select--</option>
                                            <option value="1">Invoice to customer</option>
                                            <option value="2">Welcome onboarding email</option>
                                            <option value="3">Quotation to customer</option>
                                            <option value="4">Pre-Inspection</option>
                                            <option value="5">Bulk Gas Installation Work Order</option>
                                            <option value="6">Lost customer</option>
                                            <option value="7">Not Answered</option>
                                            <option value="8">Call Later</option>
                                            <option value="9">Need More Details</option>
                                            <option value="10">Converted as Prospect</option>
                                            <option value="11">Closed/Lost</option>                                                                                                        <option value="12">Price Offered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row" id="leadDiv" style="display: none;">
                                <div class="col-md-3">
                                    <label for="">Lead Status</label>
                                    
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select name="lead_status_id" id="leadId" class="form-control">
                                            <option>--select--</option>
                                            <option value="2">Not Answered</option>
                                            <option value="3">Call Later</option>
                                            <option value="4">Need More Details</option>
                                            <option value="5">Converted as Prospect</option>
                                            <option value="6">Closed/Lost</option>                              <option value="12">Price Offered</option>                                                                                                      <option value="12">Price Offered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Subject<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" id="subjectId" name="subject" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Template<span class="error">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <textarea name="email_template" type="text" id="editor1"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('admin.list-category')}}"
                                        class="btn btn-sm btn-primary mr-1">Back</a>
                                    <button type="submit" class="btn btn-sm btn-success mr-1">Save and go back to
                                        list</button>
                                    <a href="{{route('admin.list-category')}}"
                                        class="btn btn-sm btn-danger mr-1">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card border-left-primary shadow h-100 ">
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered dataTable no-footer"
                            style="width: 100%;" role="grid" aria-describedby="example_info">
                            <thead class="bg-azure-lighter">
                                <tr role="row">
                                    <th class="text-capitalize">Template Name</th>
                                    <th class="text-capitalize">Subject</th>                                    
                                    <th>Updated On</th>
                                    <!-- <th class="text-capitalize">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $tname=array('','Invoice to customer','Welcome onboarding email','Quotation to customer',
                                'Pre-Inspection','Bulk Gas Installation Work Order','Lost customer','Not Answered',
                                'Need More Details','Converted as Prospect','Closed/Lost');
                                foreach($templates as $row){ ?>
                                <tr>
                                    <td><?= (isset($row->email_template_name) && $row->email_template_name > 0  ) ? $tname[$row->email_template_name]:'N/A'; ?></td>
                                    <td><?= $row->subject ?></td>
                                    <td><?= date('d-M-Y h:i A',strtotime($row->updated_at)); ?></td>
                                   
                                    <!-- <a  href="#" class="btn btn-sm btn-success">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </a> -->
                                   
                                </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script>
setTimeout(function() {
    $(".alert-danger").slideUp(500);
    $(".alert-success").slideUp(500);
}, 2000);

CKEDITOR.editorConfig = function(config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;
};
CKEDITOR.replace('editor1');

function getTemplate(val){
    if(['7','8','9','10','11'].includes(val)){
        $('#leadDiv').show();    
    }else{
        $('#leadDiv').hide();    
    }
    var url = "<?php echo url('/get-templates/');?>/"+val;
    $.ajax({
    type:'GET',
    url: url,
    contentType: false,
    processData: false,
    dataType: 'json',
      success: function (data)
      {
        if(data != 1){
            $('#id').val(data.id);
            $('#subjectId').val(data.subject);
            $('#leadId').val(data.lead_status_id);
            CKEDITOR.instances['editor1'].setData(data.email_template) 
            }else{
                $('#subjectId').val('');
                $('#id').val('');
                $('#leadId').val('');
                CKEDITOR.instances['editor1'].setData('');
            }
      },
      error: function(data)
      {
        console.log(data);
      }
    });
}

</script>
@endsection