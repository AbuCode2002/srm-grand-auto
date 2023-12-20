<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CompanySeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $company = new Company();

            $faker = Factory::create();

            $company->name = $faker->name;
            $company->jur_address = $faker->address;
            $company->fact_address = $faker->address;
            $company->bin = $faker->numerify('#########');
            $company->bik = $faker->numerify('#########');
            $company->iik = $faker->numerify('#########');
            $company->contact_person = $faker->numerify('#########');
            $company->contact_phone = $faker->numerify('#########');
            $company->manager_id = User::all()->random()->id;
            $company->region_id = Region::all()->random()->id;
            $company->markup = rand(1, 100);

            $company->save();
        }
    }
}
