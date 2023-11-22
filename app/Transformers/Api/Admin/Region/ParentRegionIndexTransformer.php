<?php

namespace App\Transformers\Api\Admin\Region;

use App\Models\Region;
use App\Transformers\BaseTransformer;

class ParentRegionIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = ["regions"];

//    public function includeRegions(Region $regions)
//    {
//        $model = null;
//        if ($regions->relationLoaded('regions')) {
//            $model = $regions->regions;
//        }
//
//        return $model ? $this->collection($model, new ParentRegionIndexTransformer()) : null;
//    }
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
            "budget" => $region->budget,
        ];
    }
}
