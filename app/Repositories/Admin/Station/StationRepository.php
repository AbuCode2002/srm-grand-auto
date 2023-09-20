<?php

namespace App\Repositories\Admin\Station;

use App\Models\Station;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class StationRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Station::class;
    }

    /**
     * @param int $regionId
     * @return Collection|array
     */
    public function show(int $regionId): Collection|array
    {
        return $this->model::query()->where('region_id', $regionId)->get();
    }
}
