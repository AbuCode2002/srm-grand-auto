<?php

namespace Database\Seeders;

use App\Models\DefectiveAct;
use App\Models\PartCategory;
use App\Models\PartName;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceName;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
                $service = new Service();

                $service->defective_act_id = DefectiveAct::all()->random()->id;
                $service->count = rand(1, 10);
                $service->unit = 'штук';
                $service->price = rand(10000, 100000);
                $service->sale_percent = rand(1, 100);
                $service->service_name_id = ServiceName::all()->random()->id;

                $service->save();
        }
    }
}
