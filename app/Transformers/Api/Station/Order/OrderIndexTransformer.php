<?php

namespace App\Transformers\Api\Station\Order;

use App\Models\Order;
use App\Transformers\Api\Station\Car\CarIndexTransformer;
use App\Transformers\Api\Station\Contract\ContractIndexTransformer;
use App\Transformers\Api\Station\DefectiveAct\DefectiveActIndexTransformer;
use App\Transformers\Api\Station\Region\RegionIndexTransformer;
use App\Transformers\Api\Station\Station\StationShowTransformer;
use App\Transformers\Api\Station\Status\StatusIndexTransformer;
use App\Transformers\Api\Station\User\UserIndexTransformer;
use App\Transformers\BaseTransformer;


class OrderIndexTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
        'users',
        'contract',
        'car',
        'status',
        'region',
        'station',
        'defectiveActs'
    ];

    public function includeUsers(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('users')) {
            $model = $order->users;
        }

        return $model ? $this->collection($model, new UserIndexTransformer()) : null;
    }

    public function includeContract(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('contract')) {
            $model = $order->contract;
        }

        return $model ? $this->item($model, new ContractIndexTransformer()) : null;
    }

    public function includeCar(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('car')) {
            $model = $order->car;
        }

        return $model ? $this->item($model, new CarIndexTransformer()) : null;
    }

    public function includeStatus(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('status')) {
            $model = $order->getRelation('status');
        }

        return $model ? $this->item($model, new StatusIndexTransformer()) : null;
    }

    public function includeRegion(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('region')) {
            $model = $order->region;
        }

        return $model ? $this->item($model, new RegionIndexTransformer()) : null;
    }

    public function includeStation(Order $order)
    {
        $model = null;
        if ($order->relationLoaded('station')) {
            $model = $order->station;
        }

        return $model ? $this->item($model, new StationShowTransformer()) : null;
    }

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
            "id" => $order->id,
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
            "station_id" => $order->station_id ?? null,
            "created_at" => $order->created_at ?? null,
//            "current_page" => $order->current_page ?? null,
        ];
    }
}
