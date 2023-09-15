<?php

namespace App\Http\Controllers\Client\DefectiveAct\Data;

use Spatie\LaravelData\Data;

final class DefectiveActData extends Data
{
    /**
     * @param int|null $id
     * @param int|null $order_id
     * @param int|null $total
     * @param bool|null $markup
     * @param int|null $total_with_markup
     * @param string|null $sum_sale
     */
    public function __construct(
        public ?int $id,
        public ?int $order_id,
        public ?int $total,
        public ?bool $markup,
        public ?int $total_with_markup,
        public ?string $sum_sale,
    ){}
}
