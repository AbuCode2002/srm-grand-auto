<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Driver;
use App\Models\Region;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class StationSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $station = new Station();

            $faker = Factory::create();

            $station->name = $faker->name;
            $station->region_id = Region::all()->random()->id;
            $station->address = $faker->address;
            $station->fact_address = $faker->address;
            $station->jur_address = $faker->address;
            $station->bin = $faker->numerify('#########');
            $station->bik = $faker->numerify('#########');
            $station->iik = $faker->numerify('#########');
            $station->contact_person = $faker->phoneNumber;
            $station->contact_phone = $faker->phoneNumber;

            $station->save();
        }
    }
}
