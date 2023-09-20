<?php

namespace App\Repositories\Admin\Region;

use App\Models\Region;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class RegionRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Region::class;
    }

    public function regionByUser(): Collection|array
    {
        $userId = Auth::user()->id;

        return $this->model::query()
            ->withWhereHas('user', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->get();
    }

    public function show(int $id): Collection|array
    {
        return $this->model::query()
            ->where('id', $id)->get();
    }
}
