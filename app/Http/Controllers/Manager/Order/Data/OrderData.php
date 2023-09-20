<?php

namespace App\Http\Controllers\Manager\Order\Data;

use Spatie\LaravelData\Data;

final class OrderData extends Data
{
    /**
     * @param int|null $id
     * @param int|null $car_id
     * @param int|null $region_id
     * @param bool|null $is_evacuated
     * @param int|null $contract_id
     * @param string|null $problem_description
     * @param bool|null $is_broken
     * @param string|null $service_type
     * @param int|null $driver_id
     * @param string|null $driver_type
     * @param string|null $mileage
     * @param string|null $station_id
     * @param int|null $status
     */
    public function __construct(
        public ?int $id,
        public ?int $car_id,
        public ?int $region_id,
        public ?bool $is_evacuated,
        public ?int $contract_id,
        public ?string $problem_description,
        public ?bool $is_broken,
        public ?string $service_type,
        public ?int $driver_id,
        public ?string $driver_type,
        public ?string $mileage,
        public ?string $station_id,
        public ?int $status,
    ){}
}
