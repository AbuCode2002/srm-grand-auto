<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
            $user = new User();

            $user->name = 'admin';
            $user->email = 'admin@gmail.com';
            $user->email_verified_at = '2023-11-29 18:05:29';
            $user->password = '$2y$10$os0baujGXmry7wz0iEuRD.gp7EPf6wERIg9vxewyokf1WiMm3qcti'; //password: 123456789
            $user->role_id = Role::query()->where('name', 'superAdmin')->value('id');

            $user->save();
    }
}
