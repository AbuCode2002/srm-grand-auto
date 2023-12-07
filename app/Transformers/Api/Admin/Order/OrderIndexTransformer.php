<?php

namespace App\Transformers\Api\Admin\Order;

use App\Models\Order;
use App\Transformers\Api\Admin\DefectiveAct\DefectiveActIndexTransformer;
use App\Transformers\BaseTransformer;

class OrderIndexTransformer extends BaseTransformer
{

    protected array $defaultIncludes = ['defectiveActs'];

    public function includeDefectiveActs(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('defectiveActs')) {
            $model = $order->defectiveActs;
        }
        return $model ? $this->item($model, new DefectiveActIndexTransformer()) : null;
    }
    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'order';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'orders';
    }

    /**
     * @param Order $order
     * @return array
     */
    public function transform(Order $order): array
    {
        return [
            "car_id" => $order->car_id,
            "region_id" => $order->region_id,
            "is_evacuated" => $order->is_evacuated,
            "location" => $order->location,
            "contract_id" => $order->contract_id,
            "problem_description" => $order->problem_description,
            "is_broken" => $order->is_broken,
            "service_type" => $order->service_type,
            "driver_id" => $order->driver_id,
            "driver_type" => $order->driver_type,
            "mileage" => $order->mileage,
            "station_id" => $order->station_id,
        ];
    }
}
