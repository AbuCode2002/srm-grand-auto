<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use App\Models\ServiceName;
use Illuminate\Database\Seeder;

class PartCategorySeeder extends Seeder
{
    private $category = [
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
        foreach ($this->category as $index => $item) {
            $partCategory = new PartCategory();

            $partCategory->id = $index + 1;
            $partCategory->name = $item;

            $partCategory->save();
        }
    }
}
