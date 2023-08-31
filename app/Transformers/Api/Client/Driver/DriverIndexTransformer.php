<?php

namespace App\Transformers\Api\Client\Driver;

use App\Models\Contract;
use App\Models\Driver;
use App\Models\Region;
use App\Transformers\BaseTransformer;

class DriverIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'driver';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'drivers';
    }

    /**
     * @param Region $region
     * @return array
     */
    public function transform(Driver $driver): array
    {
        return [
            "id" => $driver->id,
            "name" => $driver->name,
        ];
    }
}
