<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Work;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $excel = Excel::toCollection(new Part, '../Жүктемелер/part.xlsx');

        foreach ($excel[0] as $index => $value) {
            $works = new Work();

            if($index > 0 && $index < 370) {
                $works->name = $value[0];
                $works->save();
            }
        }
    }
}
