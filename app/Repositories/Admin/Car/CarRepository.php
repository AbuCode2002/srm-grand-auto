<?php

namespace App\Repositories\Admin\Car;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
use App\Models\Car;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\s;

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
        $carId = [];

        foreach ($data->carName as $index => $value) {
            $words[$index] = explode(' ', $value, 2);

            $carId[] = $this->model::query()
                ->where('brand', $words[$index][0])
                ->where('model', $words[$index][1])
                ->pluck('id');
        }
        return $carId;
    }

    public function serviceStatistic()
    {
        $cars = $this->model::query()
            ->with(['orders' => function ($q) {
                $q->with(['defectiveActs' => function (HasOne $q) {
                    $q->with(['service' => function (HasMany $q) {
                        $q->with('serviceName');
                }]);
            }]);
            }])
            ->get()
            ->groupBy('model');

        $carServiceNameIds = [];

        foreach ($cars as $groupIndex => $carGroup) {
            foreach ($carGroup as $statistic) {
                $services = $statistic['orders']->pluck('defectiveActs')->pluck('service');


                foreach ($services as $service) {
                    if ($service && $service->pluck('service_name_id')->isNotEmpty()) {
                        foreach ($service->pluck('serviceName')->pluck('name') as $item) {

                            $carServiceNameIds[$groupIndex] = $carServiceNameIds[$groupIndex] ?? [];
                            $carServiceNameIds[$groupIndex][] = $item;
                        }
                    }
                }
            }
        }

        $statistics = [];

        foreach ($carServiceNameIds as $index => $carServiceNameId) { // $carServiceNameId id названия сервесной услуги
            $uniqueService = array_unique($carServiceNameId);

            foreach ($uniqueService as $value) {

                $count = array_count_values($carServiceNameIds[$index])[$value];

                $statistics[$index] = $statistics[$index] ?? [];

                $statistics[$index][$value] = $count / count($carServiceNameId);
            }
        }
        return $statistics;
    }

    public function partStatistic()
    {
        $cars = $this->model::query()
            ->with(['orders' => function ($q) {
                $q->with(['defectiveActs' => function (HasOne $q) {
                    $q->with(['service' => function (HasMany $q) {
                        $q->with(['sparePart' => function($q) {
                            $q->with('partNames');
                        }]);
                        $q->pluck('service_name_id');
                    }]);
                }]);
            }])
            ->get()
            ->groupBy('model');

        $carPartNameIds = [];

        foreach ($cars as $groupIndex => $carGroup) {
            foreach ($carGroup as $statistic) {
                $services = $statistic['orders']->pluck('defectiveActs')->pluck('service');
                foreach ($services as $service) {
                    if ($service !== null) {

                        foreach ($service as $value) {
                            $parts = $value->getRelation('sparePart');
                            if ($parts->isNotEmpty()) {
                                foreach ($parts as $part) {
                                    if ($part && $part->getRelation('partNames')->category_id) {

                                        $carPartNameIds[$groupIndex] = $carPartNameIds[$groupIndex] ?? [];

                                        $carPartNameIds[$groupIndex][] = $part->getRelation('partNames')->name;

                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $statistics = [];

        foreach ($carPartNameIds as $index => $carPartNameId) { // $carPartNameId id названия запчастей
            $uniquePart = array_unique($carPartNameId);

            foreach ($uniquePart as $value) {

                $count = array_count_values($carPartNameId)[$value];

                $statistics[$index] = $statistics[$index] ?? [];

                $statistics[$index][$value] = $count / count($carPartNameId);
            }
        }
        return $statistics;
    }

    public function categoryStatistic()
    {
        $cars = $this->model::query()
            ->with(['orders' => function ($q) {
                $q->with(['defectiveActs' => function (HasOne $q) {
                    $q->with(['service' => function (HasMany $q) {
                        $q->with(['serviceName' => function ($q) {
                            $q->with('category');
                        }
                        ]);
                        $q->with(['sparePart' => function($q) {
                            $q->with('partNames');
                        }]);
                    }]);
                }]);
            }])
            ->get()
            ->groupBy('model');

        $carServiceNameIds = [];

        foreach ($cars as $groupIndex => $carGroup) {
            foreach ($carGroup as $statistic) {
                $services = $statistic['orders']->pluck('defectiveActs')->pluck('service');

                foreach ($services as $service) {
                    if ($service && $service->pluck('service_name_id')->isNotEmpty()) {
                        $categoryName = $service->pluck('serviceName')->pluck('category')->pluck('name')->toArray();

                        foreach ($categoryName as $item) {
//                        foreach ($service->pluck('serviceName')->pluck('name') as $item) {

                            $carServiceNameIds[$groupIndex] = $carServiceNameIds[$groupIndex] ?? [];
                            $carServiceNameIds[$groupIndex][] = $item;
                        }
                    }
                }
            }
        }

        $statistics = [];

        foreach ($carServiceNameIds as $index => $carServiceNameId) { // $carServiceNameId id названия сервесной услуги
            $uniqueService = array_unique($carServiceNameId);

            foreach ($uniqueService as $value) {

                $count = array_count_values($carServiceNameIds[$index])[$value];

                $statistics[$index] = $statistics[$index] ?? [];

                $statistics[$index][$value] = $count / count($carServiceNameId);
            }
        }

        return $statistics;
    }
}
