<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarType;
use App\Models\Company;
use App\Models\Contract;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CarSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            $cars = new Car();

            $cars->number = rand(111111, 999999);
            $cars->brand = $faker->name;
            $cars->model = $faker->name;
            $cars->company_id = Company::all()->random()->id;
            $cars->contract_id = Contract::all()->random()->id;
            $cars->year = rand(1990, 2023);
            $cars->vin_number = rand(1111, 9999);
            $cars->type = CarType::all()->random()->id;

            $cars->save();
        }
    }
}
