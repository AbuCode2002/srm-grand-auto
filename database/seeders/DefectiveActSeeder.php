<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Car;
use App\Models\Company;
use App\Models\Contract;
use App\Models\DefectiveAct;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Region;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class DefectiveActSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $defectiveAct = new DefectiveAct();

            $defectiveAct->order_id = Order::all()->random()->id;
            $defectiveAct->total = rand(10000, 100000);
            $defectiveAct->markup = rand(10, 70);
            $defectiveAct->total_with_markup = $defectiveAct->total * (1 + $defectiveAct->markup/100);
            $defectiveAct->sum_sale = $defectiveAct->total_with_markup * 0.88;

            $defectiveAct->save();
        }
    }
}
