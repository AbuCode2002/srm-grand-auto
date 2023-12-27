<?php

namespace App\Exports;


use App\Repositories\Client\Order\OrderRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ACW1Export implements FromCollection, WithHeadings
{
    private $orderId;

    public function __construct(
        $orderId,
        private OrderRepository  $orderRepository = new OrderRepository(),
    ) {
        $this->orderId = $orderId;

    }

    public function collection()
    {
        return $this->orderRepository->acw1($this->orderId);
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
