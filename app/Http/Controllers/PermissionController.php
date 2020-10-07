<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
        return Permission::all();
    }

    public function store(PermissionRequest $request)
    {
        return Permission::create($request->only('name'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->only('name'));
        return $permission;
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $permission;
    }
}
