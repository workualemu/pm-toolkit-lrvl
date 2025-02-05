<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        $users = User::with('roles')->get();

        return view('roles.index', compact('roles', 'permissions', 'users'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        Role::create(['name' => $request->name]);

        return back()->with('success', 'Role created successfully.');
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        Permission::create(['name' => $request->name]);

        return back()->with('success', 'Permission created successfully.');
    }

    public function assignPermission(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions);

        return back()->with('success', 'Permissions assigned successfully.');
    }

    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->syncRoles($request->roles);

        return back()->with('success', 'Role assigned successfully.');
    }

    public function destroyRole($id)
    {
        Role::findOrFail($id)->delete();
        return back()->with('success', 'Role deleted successfully.');
    }

    public function destroyPermission($id)
    {
        Permission::findOrFail($id)->delete();
        return back()->with('success', 'Permission deleted successfully.');
    }
}
