<?php

namespace App\Repositories\Client\Driver;

use App\Models\Contract;
use App\Models\Driver;
use App\Models\Region;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DriverRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Driver::class;
    }

    public function driverByUser()
    {
        //
    }
}
