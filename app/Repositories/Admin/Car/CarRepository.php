<?php

namespace App\Repositories\Admin\Car;

use App\Models\Car;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CarRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Car::class;
    }

    /**
     * @return Builder[]|Collection
     */
    public function index()
    {
        return $this->model::query()->select('id', 'number')->get();
    }

    public function show(int $id)
    {
        return $this->model::query()->where('id', $id)->get();
    }
}
