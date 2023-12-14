<?php

namespace App\Transformers\Api\Station\SparePart;

use App\Models\Service;
use App\Models\SparePart;
use App\Transformers\Api\Station\Part\PartNameIndexTransformer;
use App\Transformers\BaseTransformer;

class SparePartIndexTransformer extends BaseTransformer
{

    protected array $defaultIncludes = ['partNames'];

    public function includePartNames(SparePart $sparePart)
    {
        $model = null;
        if ($sparePart->relationLoaded('partNames')) {
            $model = $sparePart->partNames;
        }

        return $model ? $this->item($model, new PartNameIndexTransformer()) : null;
    }

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'sparePart';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'spareParts';
    }

    public function transform(SparePart $sparePart): array
    {
        return [
            "id" => $sparePart->id,
            "service_id" => $sparePart->service_id,
            "part_name_id" => $sparePart->part_name_id,
            "count" => $sparePart->count,
            "unit" => $sparePart->unit,
            "price" => $sparePart->price,
            "sale_percent" => $sparePart->sale_percent,
        ];
    }
}
