<?php

namespace App\Transformers\Api\Client\Contract;

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
        return 'Contract';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'Contracts';
    }


    /**
     * @param Contract $contract
     * @return array
     */
    public function transform(Contract $contract): array
    {
        return [
            "number_of_contract" => $contract->number_of_contract,
        ];
    }
}
