<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\PermissionRequest;
use App\Models\Webazin\Acl\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->only('label', 'name'));
        flash(Lang::get('operation completed successfully'),'success');
        return back();
    }

    public function edit(Permission $permission)
    {
        return view('admin.permission.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->only('name', 'label'));
        flash(Lang::get('operation completed successfully'),'success');
        return back();
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        flash(Lang::get('operation completed successfully'),'success');
        return back();
    }
}
