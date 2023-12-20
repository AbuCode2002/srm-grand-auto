<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CarType;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    private $column = [
        "Легковая","Микроавтобус","Грузовая","Внедорожник","Прицеп ","Автобуc",
        "Трактор","Спецтехника","Компрессор","Снегоход","Седан","Хетчбек",
        "Маршрут","Хетчбек","Минифургон","Пикап","САГ","Экскаватор погрузчик",
        "Экскаватор-грунторез","Самоходное шасси","Бизнес","Фургон","Автокара",
        "Автоцистерна","Буровая машина","Универсал","Автофургон","Автокран",
        "Автовышка","Бара","Вакуум. машина","Грузопассажирская"
        ,"Парогенератор", "Технологический","Бортовой","БКМ",
        ];
    public function run()
    {
        foreach ($this->column as $value) {
            $table = new CarType();

            $table->name = $value;

            $table->save();
        }
    }
}
