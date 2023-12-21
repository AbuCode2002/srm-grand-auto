<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    private $column = [
        'Новая заявка',
        'Ожидает назначение диагностики от СТО',
        'Назначена диагностика',
        'ДА ожидает согласования в отделе по работе с партнерами',
        'ДА на согласовании в отделе по работе с клиентами',
        'Согласован',
        'Проводятся ремонтные работы',
        'Ремонт выполнен',
        'Заявка закрыта',
        'ДА акт не принят',
        'Не оплачено',
    ];
    public function run()
    {
        foreach ($this->column as $value) {
                $status = new Status();

                $status->name = $value;

                $status->save();
        }
    }
}
