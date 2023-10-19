@extends('layouts.app')

@section('content')


<div class="app-content page-body">
	<div class="container">
	<!--Page header-->
	@if(Session::has('success'))
		<div class="alert alert-success">{{ Session::get('success') }}</div>
	@endif
		<div class="page-header">
			<div class="page-leftheader">
				<h4 class="page-title">Users</h4>
				<ol class="breadcrumb pl-0">
					<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Users</a></li>
				</ol>
			</div>
			<div class="page-rightheader">
                @permission('add-user')
				<a href="{{ route('user.add') }}" class="text-white btn btn-sm btn-primary"><i class="fe fe-plus"></i> Add User</a>
                @endpermission
            </div>
		</div>
		<!--End Page header-->

		<!--div class="row">
			<div class="col-sm-12">
				<div class="card bg-azure-lightest">
					<div class="card-body pb-0">
						<form class="">
							<label>User Search</label>
							<div class="input-group">
								<input type="text" class="form-control">
								<div class="input-group-append">
									<button type="button" class="btn btn-primary "><i class="fa fa-search text-white"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div-->

		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title col-sm-9">Search Results</div>
						<div class="float-end col-sm-3">
							<label class="d-inline">Status </label>
							<select class="form-input mt-1 mb-3 w-10 form-control float-end d-inline" id="user-status-filter">
								<option value="active" data-url="{{ route('user.list') }}"
								{{$statusFilter == 1 ? 'selected="selected"' : ''}}>Active</option>
								<option value="inactive" data-url="{{ route('user.list') }}?status=inactive"
								{{$statusFilter == 2 ? 'selected="selected"'  : '' }} >Inactive</option>
								<option value="all" data-url="{{ route('user.list') }}?status=all"
								{{$statusFilter == '' ? 'selected="selected"' : '' }} >All</option>
							</select>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead class="bg-azure-lighter">
								<tr>
									<th class="wd-15p text-capitalize">Name</th>
                                    <th class="wd-15p text-capitalize">Username</th>
									<th class="wd-15p text-capitalize">Email</th>
									<th class="wd-20p text-capitalize">Phone</th>
									<th class="wd-15p text-capitalize">Role</th>
									<th class="wd-10p text-capitalize">Status</th>
									<th class="wd-10p text-capitalize">Last Seen</th>
									<th class="wd-25p text-capitalize">Action</th>
								</tr>
							</thead>
							<tbody>

							@foreach($users as $user)
								<tr role="row" class="odd">
									<td>{{ $user->name}}</td>
                                    <td>{{ isset($user->user_name) ? $user->user_name:''}}</td>
									<td>{{ $user->email}}</td>
									<td>{{ $user->mobile_no != Null ? $user->mobile_no : 'N/A'}}</td>
									<td>{{ $user->role != Null ?  $user->role : 'N/A'}}</td>
									<td><i class="fa fa-circle text-{{$user->status == 1 ? 'success' : 'gray' }}"></i> {{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
									<td>
										<?php
											if (Cache::has('user-is-online-' . $user->id))
											{
												?>
												<i class="fa fa-circle text-success"></i>
												Last seen: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
												<?php
											}
											else
											{
												if($user->last_seen == Null)
												{
													echo 'Never logged In';
												}
												else
												{
													?>
													<i class="fa fa-circle text-gray"></i>
													Last seen: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
													<?php
												}
											}
										?>
									</td>
									<td><a href="{{ route('user.view',$user->id) }}"><i class="fa fa-eye fa-sm"></i> View</a>&nbsp;&nbsp;

										<a class="btn btn-sm btn-success" href="{{ route('user.edit',$user->id) }}" class="text-white"><i class="fa fa-pencil"></i> Edit</a>

                                    </td>
								</tr>
							@endforeach


							</tbody>
						</table>
					</div>
				</div>
				<!-- table-wrapper -->
			</div>
			<!-- section-wrapper -->
			</div>
		</div>
	</div>
</div><!-- end app-content-->


<script>
<!--------------- Check/Uncheck permissions checkboxes based on categories checkboxes code start ----------------------->
jQuery('#user-status-filter').change(function()
{
	window.location.href = jQuery(this).find(":selected").data('url');
});
</script>
@endsection
