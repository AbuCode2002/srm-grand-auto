<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use App\Models\ServiceName;
use Illuminate\Database\Seeder;

class PartCategorySeeder extends Seeder
{
    private $category = [
        'null',
        'двигатель',
        'крепеж',
        'кузовные запчасти',
        'подвеска',
        'подшипники',
        'прокладки, уплотнения',
        'приводные ремни',
        'рулевое управление',
        'система выпуска отработавших газов',
        'система отопления и вентиляции',
        'система охлаждения двигателя',
        'система очистки стёкол и фар',
        'система питания',
        'автомобильные стекла',
        'тормозная система',
        'трансмиссия',
        'фильтры',
        'электрооборудование',
        'Салон',
        'Шланги',
        'Прочее',
    ];

    public function run()
    {
        foreach ($this->category as $item) {
            $partCategory = new PartCategory();

            if ($partCategory->name === 'null') {
                $partCategory->id = 0;
            }
            $partCategory->name = $item;

            $partCategory->save();
        }
    }
}
