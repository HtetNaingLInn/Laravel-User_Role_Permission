<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {
        $users = [
            ['name' => 'mgmg', 'email' => 'mgmg@gmail.com', 'role_id' => '1'],
        ];
        $password = "password";
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'password' => Hash::make($password),

            ]);
        }
    }
}
