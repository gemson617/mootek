<?php

namespace Laratrust\Http\Controllers;

use Laratrust\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\PermissionsCategory;
use App\Models\PermissionRole;

class RolesController
{
    protected $rolesModel;
    protected $permissionModel;

    public function __construct()
    {
        $this->rolesModel = Config::get('laratrust.models.role');
        $this->permissionModel = Config::get('laratrust.models.permission');
    }

    public function index()
    {
        return View::make('laratrust::panel.roles.index', [
            'roles' => $this->rolesModel::withCount('permissions')
                ->simplePaginate(10),
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
            'permissions' => $this->permissionModel::orderBy('category_id')
            ->orderBy('name')
            ->get(['id', 'name','category_id']),
            'type' => 'role',
            'categories' => $categories,
            'roles_permissions' => $rolesPermissionsArray,
        ]);
    }

    public function show(Request $request, $id)
    {
        $role = $this->rolesModel::query()
            ->with('permissions:id,name,display_name')
            ->findOrFail($id);

        return View::make('laratrust::panel.roles.show', ['role' => $role]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $role = $this->rolesModel::create($data);
        $role->syncPermissions($request->get('permissions') ?? []);

        Session::flash('laratrust-success', 'Role created successfully');
        return redirect(route('laratrust.roles.index'));
    }

    public function edit($id)
    {
        $role = $this->rolesModel::query()
            ->with('permissions:id')
            ->findOrFail($id);

        if (!Helper::roleIsEditable($role)) {
            Session::flash('laratrust-error', 'The role is not editable');
            return redirect()->back();
        }

        $permissions = $this->permissionModel::orderBy('category_id')
            ->orderBy('name')
            ->get(['id', 'name', 'display_name','category_id'])
            ->map(function ($permission) use ($role) {
                $permission->assigned = $role->permissions
                    ->pluck('id')
                    ->contains($permission->id);

                return $permission;
            });

        $rolesPermissions = PermissionRole::get();
        $rolesPermissionsArray = array();
        foreach($rolesPermissions as $rolePermission)
        {
            $rolesPermissionsArray[$rolePermission->role_id][] = $rolePermission->permission_id;
        }
    
        $categories = PermissionsCategory::orderBy('id')->get();
        return View::make('laratrust::panel.edit', [
            'model' => $role,
            'permissions' => $permissions,
            'type' => 'role',
            'categories' => $categories,
            'roles_permissions' => $rolesPermissionsArray,
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = $this->rolesModel::findOrFail($id);

        if (!Helper::roleIsEditable($role)) {
            Session::flash('laratrust-error', 'The role is not editable');
            return redirect()->back();
        }

        $data = $request->validate([
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $role->update($data);
        $role->syncPermissions($request->get('permissions') ?? []);

        Session::flash('laratrust-success', 'Role updated successfully');
        return redirect(route('laratrust.roles.index'));
    }

    public function destroy($id)
    {
        $usersAssignedToRole = DB::table(Config::get('laratrust.tables.role_user'))
            ->where(Config::get('laratrust.foreign_keys.role'), $id)
            ->count();
        $role = $this->rolesModel::findOrFail($id);

        if (!Helper::roleIsDeletable($role)) {
            Session::flash('laratrust-error', 'The role is not deletable');
            return redirect()->back();
        }

        if ($usersAssignedToRole > 0) {
            Session::flash('laratrust-warning', 'Role is attached to one or more users. It can not be deleted');
        } else {
            Session::flash('laratrust-success', 'Role deleted successfully');
            $this->rolesModel::destroy($id);
        }

        return redirect(route('laratrust.roles.index'));
    }
}
