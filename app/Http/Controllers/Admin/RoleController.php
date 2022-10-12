<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::whereNotIn('name', ['admin'])->get();;
        return view('admin.roles.index', compact('roles'));
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request){
        $validate = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($validate);

        return redirect()->route('admin.roles.index')->with('message', 'Role Created Successfully.');
    }

    public function edit(Role $role){
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role){
        $validate = $request->validate(['name' => ['required', 'min:3']]);
        $role->update($validate);

        return redirect()->route('admin.roles.index')->with('message', 'Role Updated Successfully.');
    }

    public function destroy(Role $role){
        $role->delete();

        return back()->with('message', 'Role Deleted Successfully.');
    }

    public function givePermission(Request $request, Role $role){
        if($role->hasPermissionTo($request->permission)){
            return back()->with('message', 'Permission Exists.');
        }
        $role->givePermissionto($request->permission);
        return back()->with('message', 'Permission Added Successfully.');
    }

    public function revokePermission(Role $role, Permission $permission){
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionto($permission);
            return back()->with('message', 'Permission Revoked Successfully .');
        }
        return back()->with('message', 'Permission not Exists.');

    }
}
