<?php

namespace Database\Seeders;

use App\Models\PartCategory;
use Illuminate\Database\Seeder;

class PartCategorySeeder extends Seeder
{
    private $part = [
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
    ];

    public function run()
    {
        foreach ($this->part as $item) {

            $serviceName = new PartCategory();

            $serviceName->name = $item;

            $serviceName->save();
        }
    }
}
