<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\StorePermissionRequest;

class RolePermissionController extends Controller
{
    public function index()
    {
        // $roles = Role::with('permissions')->get();
        // $permissions = Permission::all();
        // $users = User::with('roles')->get();

        $page_title = "Roles";
        $page_type = "ROLE";
        return view('pages/users', compact('page_title', 'page_type' ));

        // return view('roles.index', compact('roles', 'permissions', 'users'));
    }

    public function storeRole(StoreRoleRequest $request)
    {
        Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? config('auth.defaults.guard'),
        ]);

        $this->forgetPermissionCache();

        return back()->with('success', 'Role created successfully.');
    }

    public function storePermission(StorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? config('auth.defaults.guard'),
        ]);

        $this->forgetPermissionCache();

        return back()->with('success', 'Permission created successfully.');
    }

    public function assignPermission(Request $request)
    {
        $guard = $request->input('guard_name', config('auth.defaults.guard'));

        $role = Role::where('guard_name', $guard)->findOrFail($request->role_id);
        $permissions = Permission::whereIn('id', $request->permissions ?? [])
            ->where('guard_name', $guard)
            ->get();

        $role->syncPermissions($permissions);
        $this->forgetPermissionCache();

        return back()->with('success', 'Permissions assigned successfully.');
    }

    public function assignRole(Request $request)
    {
        $guard = $request->input('guard_name', config('auth.defaults.guard'));
        $user = User::findOrFail($request->user_id);
        $roles = Role::whereIn('id', $request->roles ?? [])
            ->where('guard_name', $guard)
            ->get();

        $user->syncRoles($roles);
        $this->forgetPermissionCache();

        return back()->with('success', 'Role assigned successfully.');
    }

    public function destroyRole($id)
    {
        Role::findOrFail($id)->delete();
        $this->forgetPermissionCache();
        return back()->with('success', 'Role deleted successfully.');
    }

    public function destroyPermission($id)
    {
        Permission::findOrFail($id)->delete();
        $this->forgetPermissionCache();
        return back()->with('success', 'Permission deleted successfully.');
    }

    public function manageRolePermission($role_id){
        $role = Role::find($role_id);
        return view('role/role-permissions', compact('role'));
    }

    protected function forgetPermissionCache(): void
    {
        app('cache')
            ->store(config('permission.cache.store') !== 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

}
