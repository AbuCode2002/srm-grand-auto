<?php

namespace App\Repositories\Client\DefectiveAct;

use App\Http\Controllers\Client\DefectiveAct\Data\DefectiveActData;
use App\Models\DefectiveAct;
use App\Repositories\BaseRepository;

class DefectiveActRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = DefectiveAct::class;
    }

    public function store(DefectiveActData $data)
    {
        return 1;
    }
}
