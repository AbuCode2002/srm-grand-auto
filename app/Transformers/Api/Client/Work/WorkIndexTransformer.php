<?php

namespace App\Transformers\Api\Client\Work;

use App\Models\Work;
use App\Transformers\BaseTransformer;

class WorkIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'work';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'works';
    }

    /**
     * @param Work $work
     * @return array
     */
    public function transform(Work $work): array
    {
        return [
            "id" => $work->id,
            "name" => $work->name,
            "created_at" => $work->created_at,
            "updated_at" => $work->updated_at,
        ];
    }
}
