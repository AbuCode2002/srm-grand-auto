<?php

namespace App\Transformers\Api\Station\DefectivePart;

use App\Models\DefectiveAct;
use App\Models\DefectPart;
use App\Models\DefectWork;
use App\Models\Service;
use App\Transformers\Api\Station\Service\ServiceIndexTransformer;
use App\Transformers\BaseTransformer;

class DefectiveActPartsIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = ['service', 'defectWorks', 'defectParts'];

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
    public function transform(DefectPart $defectPart): array
    {
        return [
            "id" => $defectPart->id,
            "order_id" => $defectPart->amount,
            "total" => $defectPart->price,
            "markup" => $defectPart->part_name,
        ];
    }
}
