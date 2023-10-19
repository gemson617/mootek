<?php

namespace Laratrust\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\PermissionsCategory;
use App\Models\PermissionRole;

class PermissionsController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = Config::get('laratrust.models.permission');
    }

    public function index()
    {
        return View::make('laratrust::panel.permissions.index', [
            'permissions' => $this->permissionModel::simplePaginate(10),
        ]);
    }

    public function create()
    {
        $rolesPermissions = PermissionRole::get();
        $rolesPermissionsArray = array();
        foreach($rolesPermissions as $rolePermission)
        {
            $rolesPermissionsArray[$rolePermission->role_id][] = $rolePermission->permission_id;
        }

        $categories = PermissionsCategory::orderBy('id')->get();
        return View::make('laratrust::panel.edit', [
            'model' => null,
            'permissions' => null,
            'type' => 'permission',
            'categories' => $categories,
            'roles_permissions' => $rolesPermissionsArray,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'category_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $permission = $this->permissionModel::create($data);
        

        Session::flash('laratrust-success', 'Permission created successfully');
        return redirect(route('laratrust.permissions.index'));
    }

    public function edit($id)
    {
        $rolesPermissions = PermissionRole::get();
        $rolesPermissionsArray = array();
        foreach($rolesPermissions as $rolePermission)
        {
            $rolesPermissionsArray[$rolePermission->role_id][] = $rolePermission->permission_id;
        }

        $categories = PermissionsCategory::orderBy('id')->get();
        $permission = $this->permissionModel::findOrFail($id);

        return View::make('laratrust::panel.edit', [
            'model' => $permission,
            'type' => 'permission',
            'categories' => $categories,
            'roles_permissions' => $rolesPermissionsArray,
        ]);
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permissionModel::findOrFail($id);

        $data = $request->validate([
            'display_name' => 'nullable|string',
            'category_id' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $permission->update($data);

        Session::flash('laratrust-success', 'Permission updated successfully');
        return redirect(route('laratrust.permissions.index'));
    }
}
