<?php

namespace App\Transformers\Api\Station\DefectiveAct;

use App\Models\DefectiveAct;
use App\Transformers\BaseTransformer;

class DefectiveActIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'defectiveAct';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'defectiveActs';
    }


    /**
     * @param DefectiveAct $defectiveAct
     * @return array
     */
    public function transform(DefectiveAct $defectiveAct): array
    {
        return [
            "id" => $defectiveAct->id,
            "order_id" => $defectiveAct->order_id,
            "total" => $defectiveAct->total,
            "markup" => $defectiveAct->markup,
            "total_with_markup" => $defectiveAct->total_with_markup,
            "sum_sale" => $defectiveAct->sum_sale,
            "created_at" => $defectiveAct->created_at,
            "updated_at" => $defectiveAct->updated_at,
        ];
    }
}
