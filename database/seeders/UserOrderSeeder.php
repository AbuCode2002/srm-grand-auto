<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DefectiveAct;
use App\Models\Order;
use App\Models\PartCategory;
use App\Models\PartName;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceName;
use App\Models\UserCompany;
use App\Models\UserOrder;
use Illuminate\Database\Seeder;

class UserOrderSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $userOrder = new UserOrder();

            $userOrder->user_id = 64;
            $userOrder->order_id = Order::all()->random()->id;

            $userOrder->save();
        }
    }
}
