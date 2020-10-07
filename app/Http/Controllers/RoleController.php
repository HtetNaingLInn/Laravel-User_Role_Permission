<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        return Role::all();
    }

    public function store(RoleRequest $request)
    {
        return Role::create($request->only('name'));
    }

    public function update(RoleRequest $request, Role $role)
    {

        $role->update($request->only('name'));
        return $role;

    }

    public function destroy(Role $role)
    {
        $role->delete();
        return $role;

    }

}
