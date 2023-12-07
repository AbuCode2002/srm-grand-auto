<?php

namespace App\Transformers\Api\Admin\SparePart;

use App\Models\Service;
use App\Models\SparePart;
use App\Transformers\BaseTransformer;

class SparePartIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [''];

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
            "name" => $sparePart->name,
            "count" => $sparePart->count,
            "unit" => $sparePart->unit,
            "price" => $sparePart->price,
            "sale_percent" => $sparePart->sale_percent,
        ];
    }
}
