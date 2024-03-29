<?php

namespace App\Repositories\Admin\Order;

use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Models\Contract;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Models\UserOrder;
use App\Repositories\BaseRepository;
use Aws\ivschat\ivschatClient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Order::class;
    }

    public function index(int $page)
    {
        $user = Auth::user();

        $roleName = Role::query()->where('id', $user->role_id)->value('name');

        if ($roleName === 'superAdmin') {

            return $this->model::query()
                ->with('users',
                    'contract',
                    'car',
                    'status',
                    'region',
                    'station')
                ->with(['defectActs' => function (hasOne $q) {
                    $q->with(['defectParts' => function (hasMany $q) {
                        $q->select('defect_act_id', DB::raw('SUM(price_with_markup) as sum'))->groupBy('defect_act_id');
                    }]);
                }])
                ->paginate($this->perPage, ['*'], 'page', $page);

        } else if ($roleName === 'manager') {

            return $this->model::query()
                ->with('car')
                ->with('status')
                ->with('region')
                ->paginate($this->perPage, ['*'], 'page', $page);

        } else if ($roleName === 'client') {

            return $this->model::query()
                ->with('car')
                ->with('status')
                ->with('region')
                ->paginate($this->perPage, ['*'], 'page', $page);
        }
    }

    /**
     * @param OrderData $data
     * @return Order
     */
    public function store(
        OrderData $data
    ): Order
    {
        $order = new Order();

        $order->car_id = $data->car_id;
        $order->region_id = $data->region_id;
        $order->is_evacuated = $data->is_evacuated;
        $order->contract_id = $data->contract_id;
        $order->problem_description = $data->problem_description;
        $order->is_broken = $data->is_broken;
        $order->service_type = $data->service_type;
        $order->driver_id = $data->driver_id;
        $order->driver_type = $data->driver_type;
        $order->mileage = $data->mileage;

        $order->save();

        $userOrder = new UserOrder();

        $userOrder->user_id = Auth::user()->id;
        $userOrder->order_id = $order->id;

        $userOrder->save();

        return $order;
    }

    public function edit(
        Order     $order,
        OrderData $data
    )
    {
        $order->car_id = $data->car_id ? $data->car_id : $order->car_id;
        $order->region_id = $data->region_id ? $data->region_id : $order->region_id;
        $order->is_evacuated = $data->is_evacuated ? $data->is_evacuated : $order->is_evacuated;
        $order->contract_id = $data->contract_id ? $data->contract_id : $order->contract_id;
        $order->problem_description = $data->problem_description ? $data->problem_description : $order->problem_description;
        $order->is_broken = $data->is_broken ? $data->is_broken : $order->is_broken;
        $order->service_type = $data->service_type ? $data->service_type : $order->service_type;
        $order->driver_id = $data->driver_id ? $data->driver_id : $order->driver_id;
        $order->driver_type = $data->driver_type ? $data->driver_type : $order->driver_type;
        $order->mileage = $data->mileage ? $data->mileage : $order->mileage;
        $order->station_id = $data->station_id ? $data->station_id : $order->station_id;
        $order->status = $data->status ? $data->status : $order->status;

        $order->save();

        $userOrder = new UserOrder();

        $userOrder->user_id = Auth::user()->id;
        $userOrder->order_id = $order->id;

        $userOrder->save();

        return $order;
    }

    public function show(int $id)
    {
        return $this->model::query()->where('id', $id)->get();
    }

    public function sumDefectAct(array $carIds, $serviceNames)
    {
        $orders = [];
        foreach ($carIds as $carId) {
            $orders[] = $this->model::query()->whereIn('car_id', $carId)->with(['defectiveActs' => function ($q) {
                $q->with(['service' => function ($q) {
                    $q->with('serviceName');
                }]);
            }])->get();

//            $orders[] = $this->model::query()->whereIn('car_id', $carId)->with(['defectiveActs' => function (HasOne $q) {
//                $q->with(['defectWorks' => function (HasMany $q) {
//                    $q->pluck('price_with_markup');
//                }]);
//            }])->get();
        }

        $defectActWorks = [];
        foreach ($orders as $order) {
            $defectActWorks[] = $order->pluck('defectiveActs');//->pluck('service');
        }

        foreach ($serviceNames as $value => $serviceName) {
            $tempArray = ['name' => $serviceNames[$value]];
            $tempArray1 = [];

            foreach ($defectActWorks as $index1 => $defectActWork) {
                foreach ($defectActWork as $value1) {

                    if ($value1 && in_array($serviceName, $value1->service->pluck('serviceName')->pluck('name')->toArray())) {
                        $tempArray1[$index1] = '-';
                    } else {
                        $tempArray1[$index1] = '-';
                    }
                }
            }
            $tempArray['car'] = $tempArray1;
            $statistics[] = $tempArray;
        }

        foreach ($statistics as $index => $statistic) {
            foreach ($defectActWorks as $index1 => $defectActWork) {
                foreach ($defectActWork as $value1) {
                    if ($value1 && in_array($statistic['name'], $value1->service->pluck('serviceName')->pluck('name')->toArray())) {
//                        $price = $value1->total_with_markup;
                        $price = $defectActWork->pluck('total_with_markup')->toArray();

                        sort($price);

                        $result = array_filter($price, fn($value) => $value !== null);

                        if (reset($result) != end($result)) {
                            $statistics[$index]['car'][$index1] = [reset($result) . 'тг ', '  ' . end($result) . 'тг ', '  ' . count($value1->service->pluck('serviceName')->where('name', $statistic['name'])) . 'шт'];
                        } else {
                            $statistics[$index]['car'][$index1] = [reset($result) . 'тг ', '  ' . count($value1->service->pluck('serviceName')->where('name', $statistic['name'])) . 'шт'];
                        }
                    }
                }
            }
        }

        return $statistics;
    }

    public function orderWithManeger(User $manager, $startDate, $endDate)
    {
        $countOrder = $this->model::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('users', function ($q) use ($manager) {
                $q->where('users.id', $manager->id);
            })->count();

        $kpi1 = $this->model::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('users', function ($q) use ($manager) {
                $q->where('users.id', $manager->id);
            })->sum('kpi1');

        $kpi2 = $this->model::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('users', function ($q) use ($manager) {
                $q->where('users.id', $manager->id);
            })->sum('kpi2');

        $kpi3 = $this->model::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('users', function ($q) use ($manager) {
                $q->where('users.id', $manager->id);
            })->sum('kpi3');

        if ($countOrder > 0) {
            return ($kpi1 + $kpi2 + $kpi3) / (3 * $countOrder);
        } else {
            return 0;
        }
    }

    public function sumUsed($regions, $contractId)
    {
        foreach ($regions as $index => $region) {
            $array = $region['children']->pluck('id')->toArray();
            $array[] = $region['id'];

            $sumDefectAct = $this->model::query()
                ->with(['defectiveActs' => function (HasOne $q) {
                    $q->get();
                }])
                ->where('status', 9) // 9 - Заявка закрыта table statuses
                ->where('contract_id', $contractId)
                ->whereIn('region_id', $array)
                ->get();

            $sum[] = $sumDefectAct->pluck('defectiveActs')->sum('total_with_markup') * 1.12;

            $regions[$index]->usedSum = $sum[$index];
        }

            return $regions;
    }

    public function sumWork($regions, $markup, $contractId)
    {
        foreach ($regions as $index => $region) {
            $array = $region['children']->pluck('id')->toArray();
            $array[] = $region['id'];

            $sumDefectAct = $this->model::query()
                ->with(['defectiveActs' => function (HasOne $q) {
                    $q->get();
                }])
                ->where('status', '<', 9)
                ->where('status', '>', 5) // Проводяться ремонтные работы, тоесть еще не заплатили но но в будущим нужно заплатить
                ->where('contract_id', $contractId)
                ->whereIn('region_id', $array)
                ->get();

            $sum[] = $sumDefectAct->pluck('defectiveActs')->sum('total_with_markup') * 1.12;

            $regions[$index]->workSum = $sum[$index];


            $regions[$index]->restSum = $regions[$index]->budget - $regions[$index]->usedSum - $regions[$index]->workSum;

            $regions[$index]->restSumNotNDS = $regions[$index]->restSum / 1.12;

            $regions[$index]->restSumNotNDSNotMarkup = $regions[$index]->restSumNotNDS / $markup;
        }


        return $regions;
    }
}
