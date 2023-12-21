<?php

namespace Database\Seeders;

use App\Models\DefectiveAct;
use App\Models\PartCategory;
use App\Models\PartName;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceName;
use App\Models\SparePart;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
                $sparePart = new SparePart();

                $sparePart->service_id = Service::all()->random()->id;
                $sparePart->part_name_id = PartName::all()->random()->id;
                $sparePart->count = rand(1, 10);
                $sparePart->unit = 'штук';
                $sparePart->price = rand(10000, 100000);
                $sparePart->sale_percent = rand(1, 100);

                $sparePart->save();
        }
    }
}
