<?php

namespace App\Transformers\Api\Manager\Contract;

use App\Models\Contract;
use App\Transformers\BaseTransformer;

class ContractIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'contract';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'contracts';
    }


    /**
     * @param Contract $contract
     * @return array
     */
    public function transform(Contract $contract): array
    {
        return [
            "id" => $contract->id,
            "number_of_contract" => $contract->number_of_contract,
        ];
    }
}
