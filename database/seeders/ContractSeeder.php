<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ContractSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $contract = new Contract();

            $faker = Factory::create();

            $contract->company_id = Company::all()->random()->id;
            $contract->number_of_contract = $faker->name;
            $contract->budget = $faker->numerify('#########');
            $contract->enabled = rand(0, 1);
            $contract->manager_id = User::all()->random()->id;

            $contract->save();
        }
    }
}
