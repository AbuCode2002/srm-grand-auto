<?php

namespace App\Transformers\Api\Station\Diagnostics;

use App\Models\Diagnostics;
use App\Transformers\BaseTransformer;

class DiagnosticsIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'diagnostics';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'diagnostics';
    }


    /**
     * @param Diagnostics $diagnostics
     * @return array
     */
    public function transform(Diagnostics $diagnostics): array
    {
        return [
            "id" => $diagnostics->id,
            "date" => $diagnostics->date,
            "order_id" => $diagnostics->order_id,
            "created_at" => $diagnostics->created_at,
            "updated_at" => $diagnostics->updated_at,
        ];
    }
}
