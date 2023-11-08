<?php

namespace App\Http\Controllers\Station\DefectiveAct\Data;

use Spatie\LaravelData\Data;

final class DefectiveActData extends Data
{
    /**
     * @param int|null $total
     * @param int|null $total_procent
     * @param array|null $service
     * @param array|null $spare_parts
     */
    public function __construct(
        public ?int $total,
        public ?int $total_procent,
        public ?array $service,
        public ?array $spare_parts,
    ){}
}
