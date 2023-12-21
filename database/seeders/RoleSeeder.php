<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use App\Models\PartName;
use App\Models\Role;
use App\Models\ServiceName;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private $column = [
      'manager','client','superAdmin','station',
    ];

    public function run()
    {
        foreach ($this->column as  $value) {

                $role = new Role();

                $role->name = $value;

                $role->save();
        }
    }
}
