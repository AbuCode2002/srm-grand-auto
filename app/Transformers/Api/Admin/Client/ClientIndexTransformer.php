<?php

namespace App\Transformers\Api\Admin\Client;

use App\Models\Client;
use App\Transformers\BaseTransformer;

class ClientIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'client';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'clients';
    }


    /**
     * @param Client $client
     * @return array
     */
    public function transform(Client $client): array
    {
        return [
            "id" => $client->id,
            "user_id" => $client->user_id,
            "name" => $client->name,
            "address" => $client->address,
            "phone" => $client->phone,
            "email" => $client->email,
            "company_id" => $client->company_id,
            "created_at" => $client->created_at,
            "updated_at" => $client->updated_at,
        ];
    }
}
