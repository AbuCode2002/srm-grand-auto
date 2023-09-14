<?php

namespace App\Repositories\Client\DefectiveAct;

use App\Models\Contract;
use App\Models\DefectiveAct;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DefectiveActRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = DefectiveAct::class;
    }

    public function store()
    {
        return 1;
    }
}
