<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(){
        return view('admin.permissions.create');
    }

    public function store(Request $request){
        $validate = $request->validate(['name' => ['required', 'min:3']]);
        Permission::create($validate);

        return redirect()->route('admin.permissions.index')->with('message', 'Permission Created Successfully.');
    }

    public function edit(Permission $permission){
        $roles = Role::all();
        return view('admin.permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission){
        $validate = $request->validate(['name' => ['required', 'min:3']]);
        $permission->update($validate);

        return redirect()->route('admin.permissions.index')->with('message', 'Permission Updated Successfully.');
    }

    public function destroy(Permission $permission){
        $permission->delete();

        return back()->with('message', 'Permission Deleted Successfully.');
    }

    public function assignRole(Request $request, Permission $permission){
        if($permission->hasRole($request->role)){
            return back()->with('message', 'Role Exists.');
        }
        $permission->assignRole($request->role);
        return back()->with('message', 'Role Assigned Successfully.');
    }

    public function removeRole(Permission $permission, Role $role){
        if($permission->hasRole($role)){
            $permission->removeRole($role);
            return back()->with('message', 'Role Removed Successfully .');
        }
        return back()->with('message', 'Role not Exists.');
    }
}
