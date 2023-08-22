<?php

namespace App\Transformers\Api\Auth;

use App\Auth\Data\TokenData;
use App\Transformers\BaseTransformer;

class TokenDataTransformer extends BaseTransformer
{

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'token_data';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'token_data';
    }

    /**
     * @param TokenData $data
     *
     * @return array
     */
    public function transform(TokenData $data): array
    {

        return [
            'token'      => $data->token,
            'token_type' => $data->token_type,
            'expired_at' => $data->expired_at->format('Y-m-d H:i:s')
        ];
    }
}