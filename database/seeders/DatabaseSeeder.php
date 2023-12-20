<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CarType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ApplicationSeeder::class,
            UserSeeder::class,
            CarTypeSeeder::class,
            RegionSeeder::class,
            CompanySeeder::class,
            ContractSeeder::class,
            CarSeeder::class,
            DriverSeeder::class,
            StationSeeder::class,
            OrderSeeder::class,
            DefectiveActSeeder::class,
            PartCategorySeeder::class,
            PartNameSeeder::class,
            ServiceNameSeeder::class,
        ]);
    }
}
