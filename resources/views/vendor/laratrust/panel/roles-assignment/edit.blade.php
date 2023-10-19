@extends('layouts.app')

@section('content')


<div class="app-content page-body">
	<div class="container">
		<div class="page-header">
			<div class="page-leftheader">
				<h4 class="page-title">Edit User Role & Permissions</h4>
				<ol class="breadcrumb pl-0">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Admin</a></li>
					<li class="breadcrumb-item"><a href="#">User Role & Permissions</a></li>
				</ol>
			</div>
		</div>

		<!--row open-->
		<div class="row">
      <div class="col-12">

<!--main>
  <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0"-->
      <div class="flex flex-col">
        <!--div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8"-->
        <form
        method="POST"
        action="{{route('laratrust.roles-assignment.update', ['roles_assignment' => $user->getKey(), 'model' => $modelKey])}}"
        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200s bg-white-lightest"
        >
        @csrf
        @method('PUT')

        <div class="card">
          <div class="card-body">
            <label class="block">
              <span class="text-gray-700">Name</span>
              <input
                class="form-input mt-1 block w-full bg-gray-200 text-gray-600 form-control"
                name="name"
                placeholder="this-will-be-the-code-name"
                value="{{$user->name ?? 'The model doesn\'t have a `name` attribute'}}"
                readonly
                autocomplete="off"
              >
            </label>
          </div>
        </div>
        <h4 class="block text-gray-700 mt-4">Roles</h4>
        <div class="card bg-azure-lightest">
			    <div class="card-body">
				    <div class="flex flex-wrap justify-start">
              @foreach ($roles as $role)
                <label style="" class="col-sm-3">
                  <input
                    type="radio"
                    @if ($role->assigned && !$role->isRemovable)
                    class="form-checkbox focus:shadow-none focus:border-transparent text-gray-500 h-4 w-4 role-checkbox border bg-azure-light"
                    @else
                    class="form-checkbox h-4 w-4 role-checkbox border bg-azure-light"
                    @endif
                    name="role"
                    value="{{$role->getKey()}}"
                    {{$user->role_id ==  $role->getKey() ? 'selected checked' : ''}}
                    {!! $role->assigned ? 'checked' : '' !!}
                    {!! $role->assigned && !$role->isRemovable ? 'onclick="return false;"' : '' !!}
                  >
                  <span class="ml-2 {!! $role->assigned && !$role->isRemovable ? 'text-gray-600' : '' !!}">
                    {{$role->display_name ?? $role->name}}
                  </span>
					      </label>
              @endforeach
              <input type="hidden" id="user-role" name="roles" value="{{$user->role_id}}">
          </div>
        </div>
      </div>
        @if ($permissions)
          <h4 class="block text-gray-700 mt-4">Permissions</h4>
          <div class="card bg-azure-lightest">
			      <div class="card-body">
              <div class="flex flex-wrap justify-start mb-4">
                  <?php
                  $permissionsCategoryArray = array();
                  foreach ($permissions_category as $category)
                  {
                    $permissionsCategoryArray[$category->id] = $category->name;
                  }
                  $permissionCategory = '';
                  $count = 0;
                  $permissionCount = count($permissions);
                  ?>
                  @foreach ($permissions as $permission)
                    @if($permission->category_id != $permissionCategory)
                      @if($count > 0)
                      </div>
                      </div>
                      </div>
                      @endif
                      <div class="block w-full mb-5">
                        <p class="d-flex align-items-center px-3 bg-azure-lighter py-2 border">
                        <input type="checkbox" class="form-checkbox h-4 w-4 select-checkboxes border bg-azure-light mr-2" data-id="group-checkboxes-{{$permission->category_id}}" name="" value="">
                        <?php echo $permissionsCategoryArray[$permission->category_id];?>
                        </p>
                        <div id="group-checkboxes-{{$permission->category_id}}" class="group-checkboxes">
                          <div class="flex flex-wrap justify-start">
                    @endif
                    <?php
                    $permissionCategory = $permission->category_id;
                    $count++;
                    ?>
                    <label class="col-sm-3">
                      <input
                        type="checkbox"
                        class="form-checkbox h-4 w-4 permission-checkbox border bg-azure-light"
                        name="permissions[]"
                        data-val="{{$permission->getKey()}}"
                        value="{{$permission->getKey()}}"
                        {!! $permission->assigned ? 'checked' : '' !!}
                      >
                      <span class="ml-2">{{$permission->display_name ?? $permission->name}}</span>
                    </label>
                    @if($count == $permissionCount)
                    </div>
                    </div>
                    </div>
                    @endif
                  @endforeach
                </div>
              </div>
            </div>
        @endif
        <div class="flex justify-end mb-5">
          <a
            href="{{route("laratrust.roles-assignment.index", ['model' => $modelKey])}}"
            class="btn btn-red mr-4"
          >
            Cancel
          </a>
          <button class="btn btn-blue" type="submit">Save</button>
        </div>
      </form>
    <!--/div-->
  </div>
  <!--/div>
  </div>
  </main-->
  </div>
  </div>
  </div>
  <style>
  .form-checkbox.disabled:checked{
      background-image: url(data:image/svg+xml;charset=utf-8,%3Csvg viewBox='0 0 16 16' fill='%23fff' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L7 8.586 5.707 7.293z'/%3E%3C/svg%3E);
      border-color: transparent;
      background-color: #a3cbf0;
      background-size: 100% 100%;
      background-position: 50%;
      background-repeat: no-repeat;
  }
  </style>
  <script>
    <!--------------- Check/Uncheck permissions checkboxes based on categories checkboxes code start ----------------------->
    jQuery('.select-checkboxes').click(function()
    {
        var checked = jQuery(this).prop('checked');
        var dataID = jQuery(this).data('id');

        if(checked == true)
          jQuery('#'+dataID).find('input[type="checkbox"]').prop('checked','checked');
        else
        jQuery('#'+dataID).find('input[type="checkbox"]').prop('checked','');
    });

    function checkGroupCheckboxes()
    {
      jQuery('.group-checkboxes').each(function()
      {
          var checkedCount = jQuery(this).find('input[type="checkbox"]:checked').length;

          if(checkedCount > 0)
            jQuery('input[data-id="'+jQuery(this).attr('id')+'"]').prop('checked','checked');
      });
    }
    checkGroupCheckboxes();
    <!--------------- Check/Uncheck permissions checkboxes based on categories checkboxes code end ----------------------->


    <!----------------- Check/Uncheck permissions checkboxes based on roles checkboxes code start ------------------------>

    rolesPermissionsArray = [];
    <?php
    $counter = 0;
    foreach($roles_permissions as $role_permission_key => $role_permission_val)
    {
        ?>
        var rolesPermissionsArray<?php echo $role_permission_key;?> = [];
        <?php
        foreach($role_permission_val as $val)
        {
          ?>
          rolesPermissionsArray<?php echo $role_permission_key;?>.push('<?php echo $val;?>');
          <?php
        }
        ?>
        rolesPermissionsArray[<?php echo $role_permission_key;?>] = rolesPermissionsArray<?php echo $role_permission_key;?>;
        <?php
      $counter++;
    }
    ?>

    jQuery('.role-checkbox').click(function()
    {
          var checkbox = jQuery(this).val();
          if(rolesPermissionsArray[checkbox] != undefined)
          {
              jQuery('.permission-checkbox,.select-checkboxes').prop('checked','');
              console.log(rolesPermissionsArray[checkbox]);
              jQuery(rolesPermissionsArray[checkbox]).each(function(index,val)
              {
                  jQuery('input[data-val="'+val+'"]').prop('checked','checked');
              });

              checkGroupCheckboxes();
          }

          jQuery('#user-role').val(checkbox);
    });

    jQuery('.permission-checkbox').click(function()
    {
        jQuery('.select-checkboxes').prop('checked','');
        checkGroupCheckboxes();
    });

    <!----------------- Check/Uncheck permissions checkboxes based on roles checkboxes code end ------------------------>
  </script>
@endsection
