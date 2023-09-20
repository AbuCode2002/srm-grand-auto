<?php

namespace App\Transformers\Api\Station\Car;

use App\Models\Car;
use App\Models\Region;
use App\Transformers\BaseTransformer;

class CarIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'car';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'cars';
    }

    /**
     * @param Region $region
     * @return array
     */
    public function transform(Car $driver): array
    {
        return [
            "id" => $driver->id,
            "number" => $driver->number,
            "brand" => $driver->brand,
            "model" => $driver->model,
            "year" => $driver->year,
        ];
    }
}
