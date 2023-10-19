<?php

namespace Laratrust\Http\Controllers;

use Laratrust\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\PermissionsCategory;
use App\Models\PermissionRole;

class RolesAssignmentController
{
    protected $rolesModel;
    protected $permissionModel;
    protected $assignPermissions;

    public function __construct()
    {
        $this->rolesModel = Config::get('laratrust.models.role');
        $this->permissionModel = Config::get('laratrust.models.permission');
        $this->assignPermissions = Config::get('laratrust.panel.assign_permissions_to_user');
    }

    public function index(Request $request)
    {
        $modelsKeys = array_keys(Config::get('laratrust.user_models'));
        $modelKey = $request->get('model') ?? $modelsKeys[0] ?? null;
        $statusFilter = $request->get('status') && $request->get('status') == 'inactive' ? 2 : 
                ($request->get('status') && $request->get('status') == 'all' ? '' : 1);
        $userModel = Config::get('laratrust.user_models')[$modelKey] ?? null;

        if (!$userModel) {
            abort(404);
        }

        $userRolesNames = $userModel::join('roles', 'users.role_id', '=', 'roles.id')
        ->get(['users.role_id', 'roles.display_name']);

        $rolesNames = array();
        foreach($userRolesNames as $userRolesName)
        {
            $rolesNames[$userRolesName->role_id] = $userRolesName->display_name;
        }

        $users = $userModel::query();
        if($statusFilter != '')
            $users->where('status',$statusFilter);

        return View::make('laratrust::panel.roles-assignment.index', [
            'models' => $modelsKeys,
            'modelKey' => $modelKey,
            'users' => $users->withCount(['roles', 'permissions'])
                ->simplePaginate(10),
            'rolesNames' => $rolesNames,
            'status' => $statusFilter,
        ]);
    }

    public function edit(Request $request, $modelId)
    {
        $modelKey = $request->get('model');
        $userModel = Config::get('laratrust.user_models')[$modelKey] ?? null;

        if (!$userModel) {
            Session::flash('laratrust-error', 'Model was not specified in the request');
            return redirect(route('laratrust.roles-assignment.index'));
        }

        $user = $userModel::query()
            ->with(['roles:id,name', 'permissions:id,name'])
            ->findOrFail($modelId);

        $roles = $this->rolesModel::orderBy('name')->get(['id', 'name', 'display_name'])
            ->map(function ($role) use ($user) {
                $role->assigned = $user->roles
                ->pluck('id')
                    ->contains($role->id);
                $role->isRemovable = Helper::roleIsRemovable($role);

                return $role;
            });
        if ($this->assignPermissions) {
            $permissions = $this->permissionModel::orderBy('category_id')
            ->orderBy('name')
                ->get(['id', 'name', 'display_name','category_id'])
                ->map(function ($permission) use ($user) {
                    $permission->assigned = $user->permissions
                        ->pluck('id')
                        ->contains($permission->id);

                    return $permission;
                });
        }

        /*$userRoleId = $user->roles->pluck('id');
        $role = $this->rolesModel::query()
            ->with('permissions:id')
            ->findOrFail($userRoleId);*/

        $rolesPermissions = PermissionRole::get();
        $rolesPermissionsArray = array();
        foreach($rolesPermissions as $rolePermission)
        {
            $rolesPermissionsArray[$rolePermission->role_id][] = $rolePermission->permission_id;
        }

        $permissionCategories = PermissionsCategory::orderBy('id')->get();
        return View::make('laratrust::panel.roles-assignment.edit', [
            'modelKey' => $modelKey,
            'roles' => $roles,
            'permissions' => $this->assignPermissions ? $permissions : null,
            'permissions_category' => $permissionCategories,
            'user' => $user,
            'roles_permissions' => $rolesPermissionsArray,
            /*'role_permissions' => $rolePermissions,*/
        ]);
    }

    public function update(Request $request, $modelId)
    {
        $modelKey = $request->get('model');
        $userModel = Config::get('laratrust.user_models')[$modelKey] ?? null;

        if (!$userModel) {
            Session::flash('laratrust-error', 'Model was not specified in the request');
            return redirect()->back();
        }

        $user = $userModel::findOrFail($modelId);
        //$user->syncRoles($request->get('roles') ?? []); don't save role in role_user table
        if ($this->assignPermissions) {
            $user->syncPermissions($request->get('permissions') ?? []);
        }

        //// update role_id in users table /////
        $user->role_id = $request->get('roles') ?? Null;
        $user->save();

        Session::flash('laratrust-success', 'Roles and permissions assigned successfully');
        return redirect(route('laratrust.roles-assignment.index', ['model' => $modelKey]));
    }
}
