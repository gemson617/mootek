<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta content="" name="description">
	<meta content="" name="author">
	<meta name="keywords" content="" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>mootek</title>

	<!--Favicon -->
	<link rel="icon" href="{{ asset('mootek/images/home.jpg') }}" type="image/x-icon" />
	<!-- Style css -->
	<link href="{{ asset('mootek') }}/css/style.css" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/css/bootstrap.css" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/css/dark.css" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/css/custom.css" rel="stylesheet" />
	<!--Horizontal css -->
	<link id="effect" href="{{ asset('mootek') }}/plugins/horizontal-menu/dropdown-effects/fade-up.css" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/plugins/horizontal-menu/horizontal.css" rel="stylesheet" />
	<!-- P-scroll bar css-->
	<link href="{{ asset('mootek') }}/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />
	<!---Icons css-->
	{{-- <link href="{{ asset('mootek') }}/plugins/web-fonts/icons.css" rel="stylesheet" /> --}}
	<link href="{{ asset('mootek') }}/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
	{{-- <link href="{{ asset('mootek') }}/plugins/web-fonts/plugin.css" rel="stylesheet" /> --}}
	<!-- Data table css -->
	<link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
	<!-- <link href="{{ asset('mootek') }}/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" /> -->
	
	<!-- Forn-wizard css-->
	<link href="{{ asset('mootek/plugins/forn-wizard/css/forn-wizard.css') }}" rel="stylesheet" />
	<link href="{{ asset('mootek/plugins/formwizard/smart_wizard.css') }}" rel="stylesheet">
	<link href="{{ asset('mootek/plugins/formwizard/smart_wizard_theme_dots.css') }}" rel="stylesheet">
	<!-- Switcher css-->
	<link id="theme" href="{{ asset('mootek') }}/skins/hor-skin/skin.html" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/switcher/css/switcher.css" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/switcher/demo.css" rel="stylesheet" />
	<!-- Tab css -->
	<link href="{{ asset('mootek/plugins/tabs/style.css') }}" rel="stylesheet" />
	<!--- Custom Css -->
	<link href="{{ asset('mootek') }}/css/custom-1.min.css" rel="stylesheet" />
	<link href="{{ asset('mootek/plugins/accordion/accordion.css') }}" rel="stylesheet" />
	<link href="{{ asset('mootek') }}/plugins/select2/select2.min.css" rel="stylesheet" />
	<!-- Datepicker CSS  -->
	<!-- <link href="{{ asset('mootek/plugins/date-picker/date-picker.css') }}" rel="stylesheet"> -->
	<!-------------- include Jquery js ------------------------>
	<!--  -->
	<script src="{{ asset('mootek') }}/js/vendors/jquery-3.4.0.min.js"></script>
	
	<script src="{{ asset('mootek') }}/js/ajax.aspnetcdn.com_ajax_jquery.validate_1.11.1_jquery.validate.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.css" />

	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.js"></script>
	<!-- Searchable -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>   -->

	<!--- Custom Css -->

</head>
<style>
	body{
		font-family: 'Barlow', sans-serif !important;
	}
	.logo{
		background: #008ad2;
	}
	.logo:hover{
		background: #008ad2;
	}
	.nav-span{
		color: #008ad2 !important;
	}
	.btn:focus {

		box-shadow: 0px 2px 2px 2px #2C3333;

	}

	.btn-sm:focus {

		box-shadow: 0px 2px 2px 2px #2C3333;
	}

	.button:focus {

		box-shadow: 0px 2px 2px 2px #2C3333;
	}

	.fa-plus-circle{
		font-size: 20px;
		text-decoration: none;
	}
</style>

@if (Auth::check())

<body class="app">

	<div class="page">
		<div class="page-main">
			@include('layouts.partials.navbar')
			@include('layouts.partials.notifications')
			<div class="container">
				<div class="section">
					<div class="row">
						@yield('content')

					</div>

				</div>
			</div>

		</div>

		@include('layouts.partials.footer')
		<!-- Back to top -->
		<a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>
		<!-- Bootstrap4 js-->
		<script src="{{ asset('mootek') }}/js/vendors/bootstrap.bundle.min.js"></script>
		<script src="{{ asset('mootek') }}/plugins/bootstrap/popper.min.js"></script>
		<script src="{{ asset('mootek') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
		<!--Othercharts js-->
		<script src="{{ asset('mootek') }}/plugins/othercharts/jquery.sparkline.min.js"></script>
		<!-- Circle-progress js-->
		<script src="{{ asset('mootek') }}/js/vendors/circle-progress.min.js"></script>
		<!-- Jquery-rating js-->
		<script src="{{ asset('mootek') }}/plugins/rating/jquery.rating-stars.js"></script>
		<!--Horizontal js-->
		<script src="{{ asset('mootek') }}/plugins/horizontal-menu/horizontal.js"></script>
		<!-- P-scroll js-->
		<script src="{{ asset('mootek') }}/plugins/p-scrollbar/p-scrollbar.js"></script>
		<!-- Forn-wizard js-->
		<script src="{{ asset('mootek/plugins/formwizard/jquery.smartWizard.js') }}"></script>
		<script src="{{ asset('mootek/plugins/formwizard/fromwizard.js') }}"></script>
		<!-- Data tables js-->

		<!-- <script src="{{ asset('mootek') }}/plugins/datatable/jquery.dataTables.min.js"></script> -->
		<script src="{{ asset('mootek') }}/plugins/datatable/dataTables.bootstrap4.min.js"></script>
		<!-- <script src="{{ asset('mootek') }}/js/datatables.js"></script>  -->
		
		<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>



		<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

		<!-- Select2 js -->
		<script src="{{ asset('mootek') }}/plugins/select2/select2.full.min.js"></script>
		<!-- Custom Js-->
		<script src="{{ asset('mootek') }}/js/custom.js"></script>
		<!-- Datepicker JS -->
		<!-- <script src="{{ asset('mootek') }}/plugins/date-picker/date-picker.js"></script>
				<script src="{{ asset('mootek') }}/plugins/date-picker/jquery-ui.js"></script>
				<script src="{{ asset('mootek') }}/plugins/input-mask/jquery.maskedinput.js"></script> -->
		<!-- Switcher Js-->
		<script src="{{ asset('mootek') }}/switcher/js/switcher.js"></script>
		<!-- Tab Js -->
		<script src="{{ asset('mootek//plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
		<script src="{{ asset('mootek/js/tabs.js') }}"></script>

		<!-- Chart JS -->
		<script src="{{ asset('mootek/js/mootek_chart.js') }}"></script>

		<!-- <script src="{{asset('mootek/js/form-validation.js')}}" type="text/javascript"></script>  -->
		<!-- added 30-07-2022 -->
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>

	</div>
	<div id='delete_modal' class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Delete</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<input type="hidden" id='delete_id' name='id'>
				<div class="modal-body">
					<p>Are you Sure to delete These Record?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary delete" id='delete'>Yes,Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id='staus_company' class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Select Company</h5>
					<button type="button" class="close" data-dismiss="modal" onclick="closemodel" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{route('add.company')}}" method='post'>
					@csrf
					<div class="modal-body">
						<div class="row">
							<div class="form-group">
								<select class="form-select" id='company_id' name='id'>
									<?php $status = App\Models\company::get();

									foreach ($status as $val) {
									?>
										<option value="<?php echo $val->id ?>" <?php echo   $val->status == '1' ? ' selected' : '' ?>><?= $val->company;?></option>
									<?php } ?>
								</select>
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id='delete'>Update</button>
						<button type="button" class="btn btn-secondary close_button" data-dismiss="modal">Close</button>
					</div>
				</form>

			</div>
		</div>
	</div>

	<script>

		function closemodel() {
				$('#staus_company').modal('hide');
			}
		</script>

{{-- change status --}}
	<div class="modal change_status" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title">Status</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<form action="{{route('change.status')}}" method="post">
				@csrf
				<div class="modal-body">
					<input type="hidden" name='status' id='changestatus'>
				 <input type="hidden" id="change_id" name="change_id">
				 <input type="hidden" id="tablename" value="Designation" name="table">
	
				  <p>Are You Change <strong id="check_status"></strong> status?</p>
				</div>
		   
	
			<div class="modal-footer">
			  <button type="submit" class="btn btn-primary">Yes,change Status</button>
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</form>
		  </div>
		</div>
	  </div>

	<script>
		            $(".change").click(function(){  
                table=$(this).attr('data-name');
               
           status=$(this).attr('data');
		//    alert(status);
            check_status =(status=='0')?'Active':'InActive';
            change =status=='0'?'1':'0';
            status_id=$(this).val();
            $("#changestatus").val(change);
            $("#change_id").val(status_id);
            $("#tablename").val(table);
			$("#table").val('company');
            // alert(check_status);
            if(status =='0'){
                $("#check_status").text(check_status).css('color','blue');
            }else{
                $("#check_status").text(check_status).css('color','red');
            }
           $(".change_status").modal('show');
		   
    });
	
    setTimeout(function() {
            $(".alert-danger").slideUp(500);
            $(".alert-success").slideUp(500);
        }, 2000);
  
			//company status
			$(".status").click(function() {
			$("#staus_company").css('display','block');
			$('#company_id').select2('destroy');
		});
		$(".close_button").click(function() {
			$("#staus_company").css('display','none');
			$('#company_id').select2('destroy');
		});
		
		//state
		function get_state(country_id) {
			// console.log(country_id);
			$.ajax({
				url: "{{route('get.state')}}",
				method: "POST",
				type: "ajax",
				data: {
					"_token": "{{ csrf_token() }}",
					country_id: country_id
				},
				success: function(result) {
					console.log(result);
					var data = JSON.parse(result);
					$('#state')
						.find('option')
						.remove();
					$.each(data, function(key, value) {
						var option = '<option value="' + value.id + '">' + value.name +
							'</option>';
						$('#state').append(option);
					});
				},
				error: function(error) {
					console.log(error);
				}
			});
		}
		//city
		function get_city(state_id,no) {
			$.ajax({
				url: "{{route('get.city')}}",
				method: "POST",
				type: "ajax",
				data: {
					"_token": "{{ csrf_token() }}",

					state_id: state_id
				},
				success: function(result) {
					var data = JSON.parse(result);
					// alert(data);
					$('#city'+no)
						.find('option')
						.remove();
					$.each(data, function(key, value) {
						var option = '<option value="' + value.id + '">' + value.city_name +
							'</option>';
						$('#city'+no).append(option);
					});
				},
				error: function(error) {
					console.log(error);
				}
			});
		}
		function get_b_city(state_id,no) {
			$.ajax({
				url: "{{route('get.city')}}",
				method: "POST",
				type: "ajax",
				data: {
					"_token": "{{ csrf_token() }}",

					state_id: state_id
				},
				success: function(result) {
					var data = JSON.parse(result);
					// alert(data);
					$('#billing_city'+no)
						.find('option')
						.remove();
					$.each(data, function(key, value) {
						var option = '<option value="' + value.id + '">' + value.city_name +
							'</option>';
						$('#billing_city'+no).append(option);
					});
				},
				error: function(error) {
					console.log(error);
				}
			});
		}
		// form cancel
		$(".cancel").click(function() {
			$('form[id="form"]')[0].reset();
			$('select').val('').select2();

			CKEDITOR.instances['content'].setData('');
			CKEDITOR.instances['details1'].setData('');
		});
		//top scroll event
		function scrollToTop() {
			$(window).scrollTop(0);
		}
		//Searchable script
		//change selectboxes to selectize mode to be searchable
		
		$("select").select2();
		

		//hide alert
		// setTimeout(function() {
		// 	$(".alert-danger").slideUp(500);
		// 	$(".alert-success").slideUp(500);
		// }, 2000);
	</script>
	<script>
                $(document).ready(function() {
					$('#datatable').DataTable({
					"ordering": false
    });                });
            </script>
</body>
@else

<body class="h-100vh">
	<div class="container">
		<div class="row">
			@yield('content')

		</div>
	</div>
</body>
@endif

</html>