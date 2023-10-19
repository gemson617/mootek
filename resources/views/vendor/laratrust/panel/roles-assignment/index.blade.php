@extends('layouts.app')

@section('content')

<div class="app-content page-body">
	<div class="container">
		<div class="page-header">
			<div class="page-leftheader">
				<h4 class="page-title">Roles & Permisisons Assignment</h4>
				<ol class="breadcrumb pl-0">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Admin</a></li>
					<li class="breadcrumb-item"><a href="#">Roles & Permisisons Assignment</a></li>
				</ol>
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

		<!--row open-->
		<div class="row">
      <div class="col-12">
      <select class="form-input mt-1 mb-3 w-25 form-control float-end" id="user-status-filter">
        <option value="active" data-url="{{ route('laratrust.roles-assignment.index') }}"
        {{$status == 1 ? 'selected="selected"' : ''}}>Active</option>
        <option value="inactive" data-url="{{ route('laratrust.roles-assignment.index') }}?status=inactive"
        {{$status == 2 ? 'selected="selected"'  : '' }} >Inactive</option>
        <option value="all" data-url="{{ route('laratrust.roles-assignment.index') }}?status=all"
        {{$status == '' ? 'selected="selected"' : '' }} >All</option>
      </select>

        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered no-footer">
                <thead class="bg-azure-lighter">
                  <tr>
                    <th class="th w-5">Id</th>
                    <th class="th">Name</th>
                    <th class="th"># Roles</th>
                    @if(config('laratrust.panel.assign_permissions_to_user'))<th class="th"># Permissions</th>@endif
                    <th class="th">Status</th>
                    <th class="th w-5">Action</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  @foreach ($users as $user)
                  <tr class="{{$user->status == 1 ? 'active' : 'in-active' }}">
                    <td class="td text-sm leading-5 text-gray-900">
                      {{$user->getKey()}}
                    </td>
                    <td class="td text-sm leading-5 text-gray-900">
                      {{$user->name ?? 'The model doesn\'t have a `name` attribute'}}
                    </td>
                    <td class="td text-sm leading-5 text-gray-900">
                      {{-- $user->roles_count --}}
                      @isset($rolesNames[$user->role_id] )
                      {{ $rolesNames[$user->role_id] }}
                      @endisset
                    </td>
                    @if(config('laratrust.panel.assign_permissions_to_user'))
                    <td class="td text-sm leading-5 text-gray-900">
                      {{$user->permissions_count}}
                    </td>
                    @endif
                    <td class="td text-sm leading-5 ">
                      <i class="fa fa-circle text-{{$user->status == 1 ? 'success' : 'gray' }}"></i> {{$user->status == 1 ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="flex justify-end px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                      <a
                        href="{{route('laratrust.roles-assignment.edit', ['roles_assignment' => $user->getKey(), 'model' => $modelKey])}}"
                        class="btn btn-primary"
                      ><i class="fa fa-pencil"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @if ($modelKey)
                {{ $users->appends(['model' => $modelKey])->links('laratrust::panel.pagination') }}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
  </div>

  <script>
  <!--------------- Check/Uncheck permissions checkboxes based on categories checkboxes code start ----------------------->
  jQuery('#user-status-filter').change(function()
  {
    window.location.href = jQuery(this).find(":selected").data('url');
  });
  </script>
@endsection
