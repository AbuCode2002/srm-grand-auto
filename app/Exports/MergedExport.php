<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MergedExport implements FromCollection, WithHeadings
{
    private $orderId;

    public function __construct($orderId,)
    {
        $this->orderId = $orderId;
    }

    public function collection()
    {
        return collect([
            new ACW1Export($this->orderId),
            new ACW2Export($this->orderId),
        ]);
    }

    public function headings(): array
    {
        return [
            'Заявка',
            'Автомобиль',
            'Заказчик',
            'Гос. номер',
            'VIN',
        ];
    }
}
