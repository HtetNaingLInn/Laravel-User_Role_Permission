<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('role', RoleController::class)->except('create', 'edit', 'show');
Route::resource('permission', PermissionController::class)->except('create', 'edit', 'show');
Route::resource('user', UserController::class)->except('create', 'edit');
