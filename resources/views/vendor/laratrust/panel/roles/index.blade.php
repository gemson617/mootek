@extends('layouts.app')

@section('content')

<div class="app-content page-body">
	<div class="container">
		<div class="page-header">
			<div class="page-leftheader">
				<h4 class="page-title">Roles</h4>
				<ol class="breadcrumb pl-0">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Admin</a></li>
					<li class="breadcrumb-item"><a href="#">Roles </a></li>
				</ol>
			</div>
			<div class="page-rightheader">
                @permission('add-roles')
				<a href="{{route('laratrust.roles.create')}}" class="text-white btn btn-sm btn-primary">
					<i class="fe fe-plus"></i> Add Role
				</a>
                @endpermission
			</div>
		</div>

		@foreach (['error', 'warning', 'success'] as $msg)
        @if(Session::has('laratrust-' . $msg))
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body bg-success p-3">
                <p>{{ Session::get('laratrust-' . $msg) }}</p>
              </div>
            </div>
          </div>
        </div>
        @endif
      @endforeach

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered no-footer">
								  <thead class="bg-azure-lighter">
									<tr>
									  <th class="th w-5">Id</th>
									  <th class="th">Display Name</th>
									  <th class="th">Name</th>
									  <th class="th"># Permissions</th>
									  <th class="th w-5">Actions</th>
									</tr>
								  </thead>
								  <tbody class="bg-white">
									@foreach ($roles as $role)
									<tr>
									  <td class="td text-sm leading-5 text-gray-900">
										{{$role->getKey()}}
									  </td>
									  <td class="td text-sm leading-5 text-gray-900">
										{{$role->display_name}}
									  </td>
									  <td class="td text-sm leading-5 text-gray-900">
										{{$role->name}}
									  </td>
									  <td class="td text-sm leading-5 text-gray-900">
										{{$role->permissions_count}}
									  </td>
									  <td class="flex justify-end px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
										<div class="btn-group btn-group-sm" role="group">
										@permission('eidt-roles')
                                            @if (\Laratrust\Helper::roleIsEditable($role))
										<a href="{{route('laratrust.roles.edit', $role->getKey())}}" class="btn btn-primary">
										<i class="fa fa-pencil"></i>
										</a>
										@else
										<a href="{{route('laratrust.roles.show', $role->getKey())}}" class="text-blue-600 hover:text-blue-900">Details</a>
										@endif
										<form
										  action="{{route('laratrust.roles.destroy', $role->getKey())}}"
										  method="POST"
										  onsubmit="return confirm('Are you sure you want to delete the record?');"
										>
										  @method('DELETE')
										  @csrf
                                          @endpermission
                                          @permission('delete-roles')
										  <button
											type="submit"
											class="{{\Laratrust\Helper::roleIsDeletable($role) ? 'btn btn-danger' : 'text-gray-600 hover:text-gray-700 cursor-not-allowed'}} ml-4"
											@if(!\Laratrust\Helper::roleIsDeletable($role)) disabled @endif
										  ><i class="fa fa-times"></i></button>
                                          @endpermission
										</form>
										</div>
									  </td>
									</tr>
									@endforeach
								</tbody>
							</table>
							  {{ $roles->links('laratrust::panel.pagination') }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
