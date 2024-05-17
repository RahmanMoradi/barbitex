<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\RoleRequest;
use App\Models\Webazin\Acl\Permission;
use App\Models\Webazin\Acl\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('admin.role.create', compact('permissions'))->with('message' , ['content' => 555555]);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only('label', 'name'));

        $role->permissions()->sync($request->permission_id);

        flash(Lang::get('operation completed successfully'),'success');
        return back();
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name', 'label'));
        $role->permissions()->sync($request->permission_id);
        flash(Lang::get('operation completed successfully'),'success');
        return back();
    }

    public function destroy(Role $role)
    {
        $role->delete();
        flash(Lang::get('operation completed successfully'),'success');
        return back();
    }
}
