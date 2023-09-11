<?php

namespace App\Repositories\Client\Station;

use App\Http\Controllers\Client\Station\Data\StationData;
use App\Models\Contract;
use App\Models\Station;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
