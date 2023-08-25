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
            'access_token'      => $data->token,
            'expired_at' => $data->expired_at->format('Y-m-d H:i:s')
        ];
    }
}
