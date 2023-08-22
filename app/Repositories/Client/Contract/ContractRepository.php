<?php

namespace App\Repositories\Client\Contract;

use App\Models\Contract;
use App\Repositories\BaseRepository;

class ContractRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Contract::class;
    }
}
