<?php

namespace App\Repositories\Station\Application;

use App\Models\Application;
use App\Repositories\BaseRepository;

class ApplicationRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Application::class;
    }
}
