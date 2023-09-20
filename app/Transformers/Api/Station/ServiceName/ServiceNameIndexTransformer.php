<?php

namespace App\Transformers\Api\Station\ServiceName;

use App\Models\ServiceName;
use App\Transformers\BaseTransformer;

class ServiceNameIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'serviceName';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'serviceNames';
    }

    public function transform(ServiceName $serviceName): array
    {
        return [
            "id" => $serviceName->id,
            "name" => $serviceName->name,
        ];
    }
}
