<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DefectiveAct;
use App\Models\Order;
use App\Models\PartCategory;
use App\Models\PartName;
use App\Models\Region;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceName;
use App\Models\UserCompany;
use App\Models\UserOrder;
use App\Models\UserToRegion;
use Illuminate\Database\Seeder;

class UserToRegionSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $userRegion = new UserToRegion();

            $userRegion->user_id = 1;
            $userRegion->region_id = Region::all()->random()->id;

            $userRegion->save();
        }
    }
}
