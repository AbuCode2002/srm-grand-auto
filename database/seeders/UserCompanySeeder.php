<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\DefectiveAct;
use App\Models\PartCategory;
use App\Models\PartName;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceName;
use App\Models\UserCompany;
use Illuminate\Database\Seeder;

class UserCompanySeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1; $i++) {
            $userCompany = new UserCompany();

            $userCompany->user_id = 64;
            $userCompany->company_id = Company::all()->random()->id;

            $userCompany->save();
        }
    }
}
