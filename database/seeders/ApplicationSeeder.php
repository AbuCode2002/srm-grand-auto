<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    private $type = ["Услуга", "Запчасть"];
    public function run()
    {
        foreach ($this->type as $value) {
            $application = new Application();

            $application->type = $value;

            $application->save();
        }
    }
}
