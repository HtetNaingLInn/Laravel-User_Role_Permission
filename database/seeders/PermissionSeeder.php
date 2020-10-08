<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        $permissions = ['create', 'edit', 'delete', 'update', 'show'];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }
    }
}
