<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ServiceName;
use Illuminate\Database\Seeder;

class OrderKPiSeeder extends Seeder
{
    public function run()
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            dd($order);
            $order->kpi1 = rand(0,1);
            $order->kpi2 = rand(0,1);
            $order->kpi3 = rand(0,1);

            $order->save();
        }

    }
}
