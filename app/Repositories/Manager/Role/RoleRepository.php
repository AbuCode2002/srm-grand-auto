<?php

namespace App\Repositories\Manager\Role;

use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Role::class;
    }
}
