<?php

namespace App\Http\Controllers\Client\Order\Data;

use Spatie\LaravelData\Data;

final class OrderData extends Data
{
    /**
     * @param int $car_id
     * @param int $client_id
     * @param int $region_id
     * @param bool $is_evacuated
     * @param int $contract_id
     * @param string $problem_description
     * @param bool $is_broken
     * @param string $service_type
     * @param int $driver_id
     * @param string $driver_type
     * @param string $mileage
     */
    public function __construct(
        public int $car_id,
        public int $client_id,
        public int $region_id,
        public bool $is_evacuated,
        public int $contract_id,
        public string $problem_description,
        public bool $is_broken,
        public string $service_type,
        public int $driver_id,
        public string $driver_type,
        public string $mileage,
    ){}
}
