<?php

namespace App\Transformers\Api\Client\Part;

use App\Models\PartName;
use App\Transformers\BaseTransformer;

class PartNameIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'partName';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'partNames';
    }

    public function transform(PartName $partName): array
    {
        return [
            "id" => $partName->id,
            "name" => $partName->name,
        ];
    }
}
