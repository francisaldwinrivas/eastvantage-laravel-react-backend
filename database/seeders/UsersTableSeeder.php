<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Faker;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = array(
            'name' => 'Admin User',
            'email' => 'adminuser@email.com',
            'password' => Hash::make('Password2024!')
        );

        $adminRole = Role::where('name', 'Administrator')->first();
        $user = User::create($userData);
        $user->roles()->attach($adminRole->id);
    }
}
