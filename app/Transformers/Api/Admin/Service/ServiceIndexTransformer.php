<?php

namespace App\Transformers\Api\Admin\Service;

use App\Models\Service;
use App\Models\ServiceName;
use App\Models\SparePart;
use App\Transformers\Api\Station\SparePart\SparePartIndexTransformer;
use App\Transformers\BaseTransformer;

class ServiceIndexTransformer extends BaseTransformer
{

    protected array $defaultIncludes = ['sparePart'];

    public function includeSparePart(Service $service)
    {
        $model = null;
        if ($service->relationLoaded('sparePart')) {
            $model = $service->sparePart;
        }

        return $model ? $this->collection($model, new SparePartIndexTransformer()) : null;
    }

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'service';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'services';
    }

    public function transform(Service $service): array
    {
        return [
            "id" => $service->id,
            "defective_act_id" => $service->defective_act_id,
            "name" => $service->name,
            "count" => $service->count,
            "unit" => $service->unit,
            "price" => $service->price,
            "sale_percent" => $service->sale_percent,
        ];
    }
}
