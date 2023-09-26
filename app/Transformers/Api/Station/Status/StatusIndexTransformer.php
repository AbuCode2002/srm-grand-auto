<?php

namespace App\Transformers\Api\Station\Status;

use App\Models\Service;
use App\Models\ServiceName;
use App\Models\SparePart;
use App\Models\Status;
use App\Transformers\Api\Station\SparePart\SparePartIndexTransformer;
use App\Transformers\BaseTransformer;

class StatusIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = ['sparePart'];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'status';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'statuses';
    }

    public function transform(Status $status): array
    {
        return [
            "id" => $status->id,
            "name" => $status->name,
        ];
    }
}
