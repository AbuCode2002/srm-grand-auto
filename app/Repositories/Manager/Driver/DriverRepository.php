<?php

namespace App\Repositories\Manager\Driver;

use App\Models\Driver;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class DriverRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Driver::class;
    }

    public function showName(): Collection
    {
        return $this->model::query()->select( 'id', 'name')->get();
    }
}
