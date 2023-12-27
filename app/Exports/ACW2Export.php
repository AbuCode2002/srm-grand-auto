<?php

namespace App\Exports;


use App\Repositories\Client\DefectiveAct\DefectiveActRepository;
use App\Repositories\Client\Order\OrderRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ACW2Export implements FromCollection, WithHeadings
{
    private $orderId;

    public function __construct(
        $orderId,
        private DefectiveActRepository  $defectiveAct = new DefectiveActRepository(),
    ) {
        $this->orderId = $orderId;
    }

    public function collection()
    {
        return $this->defectiveAct->acw2($this->orderId);
    }

    public function headings(): array
    {
        return [
            'Наименование работ (услуг)
            (в разрезе их подвидов в соответсвий
            с технической спецификаций, заданием,
            графиком выполнения работ (услуг) при их наличий)',

            'Дата выполнения работ (оказания услуг)**',

            'Единица измерения',

            'Колличество (час)',

            'Цена за единицу без НДС (тенге)',

            'Стоимость без НДС(тенге)',

            'Сумма НДС(тенге)',

            'Стоимость с учетом НДС(тенге)',
        ];
    }
}
