<?php

namespace App\Repositories\Admin\ServiceName;

use App\Models\ServiceName;
use App\Repositories\BaseRepository;

class ServiceNameRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = ServiceName::class;
    }
}
