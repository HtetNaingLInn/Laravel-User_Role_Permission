<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderby('id', 'desc')->get();
        return UserResource::collection($users);
    }

    public function store(UserRequest $request)
    {
        $permissions = $request->permission;
        $password = $request->password;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => $request->role_id,
        ]);
        foreach ($permissions as $permission) {
            $user->permissions()->attach([$permission]);
        }
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, $id)
    {
        $permissions = $request->permission;
        $password = $request->password;

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => $request->role_id,
        ]);

        $user->permissions()->sync($permissions);

        return new UserResource($user);

    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $user->permissions()->detach();
    }
}
