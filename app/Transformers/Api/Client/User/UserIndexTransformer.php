<?php

namespace App\Transformers\Api\Client\User;

use App\Models\User;
use App\Transformers\BaseTransformer;

class UserIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'users';
    }

    /**
     * @param $user
     * @return array
     */
    public function transform($user): array
    {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "email_verified_at" => $user->email_verified_at,
            "role_id" => $user->role_id,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at,
        ];
    }
}
