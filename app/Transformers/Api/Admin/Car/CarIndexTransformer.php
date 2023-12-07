<?php

namespace App\Transformers\Api\Admin\Car;

use App\Models\Car;
use App\Models\DefectiveAct;
use App\Models\Order;
use App\Models\Region;
use App\Models\Service;
use App\Transformers\Api\Admin\DefectiveAct\DefectiveActIndexTransformer;
use App\Transformers\Api\Admin\Order\OrderIndexTransformer;
use App\Transformers\Api\Admin\Service\ServiceIndexTransformer;
use App\Transformers\Api\Admin\SparePart\SparePartIndexTransformer;
use App\Transformers\BaseTransformer;

class CarIndexTransformer extends BaseTransformer
{

    protected array $defaultIncludes = ['order'];

    public function includeOrder(Car $car)
    {
        $model = null;
        if ($car->relationLoaded('orders')) {
            $model = $car->orders;
        }

        return $model ? $this->collection($model, new OrderIndexTransformer()) : null;
    }

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
