<?php

namespace App\Transformers\Api\Manager\Region;

use App\Models\Region;
use App\Transformers\BaseTransformer;

class RegionIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'region';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'regions';
    }

    /**
     * @param Region $region
     * @return array
     */
    public function transform(Region $region): array
    {
        return [
            "id" => $region->id,
            "region_name" => $region->region_name,
        ];
    }
}
