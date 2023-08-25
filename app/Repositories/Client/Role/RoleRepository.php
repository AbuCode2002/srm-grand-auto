<?php

namespace App\Repositories\Client\Role;

use App\Models\Application;
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
