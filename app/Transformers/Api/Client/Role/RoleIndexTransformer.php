<?php

namespace App\Transformers\Api\Client\Role;

use App\Models\Role;
use App\Transformers\BaseTransformer;

class RoleIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'role';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'roles';
    }

    /**
     * @param Role $role
     * @return array
     */
    public function transform(Role $role): array
    {
        return [
            "id" => $role->id,
            "name" => $role->name,
        ];
    }
}
