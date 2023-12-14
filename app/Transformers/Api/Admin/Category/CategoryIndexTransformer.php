<?php

namespace App\Transformers\Api\Admin\Category;

use App\Models\PartCategory;
use App\Models\Region;
use App\Transformers\BaseTransformer;

class CategoryIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = ['order'];
//
//    public function includeOrder(PartCategory $category)
//    {
//        $model = null;
//        if ($car->relationLoaded('orders')) {
//            $model = $category->orders;
//        }
//
//        return $model ? $this->collection($model, new OrderIndexTransformer()) : null;
//    }

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'category';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'categories';
    }

    /**
     * @param PartCategory $category
     * @return array
     */
    public function transform(PartCategory $category): array
    {
        return [
            "id" => $category->id,
            "name" => $category->name,
        ];
    }
}
