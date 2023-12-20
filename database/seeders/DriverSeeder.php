<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Driver;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class DriverSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $driver = new Driver();

            $faker = Factory::create();

            $driver->phone = $faker->phoneNumber;
            $driver->name = $faker->name;
            $driver->company_id = Company::all()->random()->id;

            $driver->save();
        }
    }
}
