<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Car;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Region;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class OrderSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $order = new Order();

            $faker = Factory::create();

            $order->car_id = Car::all()->random()->id;
            $order->service_type = Application::all()->random()->type;
            $order->driver_type = 'Водитель';
            $order->mileage = $faker->numerify('#####');
            $order->is_broken = rand(0, 1);
            $order->region_id = Region::all()->random()->id;
            $order->driver_id = Region::all()->random()->id;
            $order->problem_description = $faker->text;
            $order->status = 1;
            $order->contract_id = Contract::all()->random()->id;
            $order->station_id = Station::all()->random()->id;
            $order->kpi1 = 0;
            $order->kpi2 = 0;
            $order->kpi3 = 0;
            $order->paid = 0;

            $order->save();
        }
    }
}
