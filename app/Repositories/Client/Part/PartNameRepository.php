<?php

namespace App\Repositories\Client\Part;

use App\Models\PartName;
use App\Repositories\BaseRepository;

class PartNameRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = PartName::class;
    }
}
