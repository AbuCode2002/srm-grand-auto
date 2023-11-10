<?php

namespace App\Repositories\Admin\Car;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
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
        return $this->model::query()->get();
    }

    public function idNumber()
    {
        return $this->model::query()->select('id', 'number')->get();
    }

    public function show(int $id)
    {
        return $this->model::query()->where('id', $id)->get();
    }

    public function carName()
    {
        $brands = $this->model::query()->pluck('brand');

        $models = $this->model::query()->pluck('model');

        foreach ($brands as $index => $brand) {
            $name[$index] = $brand . " " . $models[$index];
         }

        return array_values(array_unique($name));
    }

    public function carIds(CarStatisticData $data)
    {
        foreach ($data->carName as $index => $value) {
            $words[$index] = explode(' ', $value, 2);

            $carId[] = $this->model::query()
                ->where('brand', $words[$index][0])
                ->where('model', $words[$index][1])
                ->pluck('id');
        }
        return $carId;
    }
}
