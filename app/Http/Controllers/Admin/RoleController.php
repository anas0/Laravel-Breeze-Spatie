<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request){
        $validate = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($validate);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role){
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role){
        $validate = $request->validate(['name' => ['required', 'min:3']]);
        $role->update($validate);

        return redirect()->route('admin.roles.index');
    }
}
