<?php

namespace App\Transformers\Api\Station\Station;

use App\Models\Station;
use App\Transformers\BaseTransformer;

class StationShowTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'station';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'stations';
    }


    /**
     * @param Station $contract
     * @return array
     */
    public function transform(Station $contract): array
    {
        return [
            "id" => $contract->id,
            "name" => $contract->name,
            "address" => $contract->address,
            "contact_phone" => $contract->contact_phone,
            "bin" => $contract->bin,
            "bik" => $contract->bik,
            "iik" => $contract->iik,
            "fact_address" => $contract->fact_address,
        ];
    }
}
