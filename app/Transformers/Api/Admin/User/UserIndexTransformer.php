<?php

namespace App\Transformers\Api\Admin\User;

use App\Transformers\BaseTransformer;

class   UserIndexTransformer extends BaseTransformer
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
    public function transform($users): array
    {
        return [
            "id" => $users->id,
            "name" => $users->name,
            "email" => $users->email,
            "email_verified_at" => $users->email_verified_at,
            "role_id" => $users->role_id,
            "created_at" => $users->created_at,
            "updated_at" => $users->updated_at,
        ];
    }
}
