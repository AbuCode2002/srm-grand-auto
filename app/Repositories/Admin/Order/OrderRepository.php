<?php

namespace App\Repositories\Admin\Order;

use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Models\Order;
use App\Models\Role;
use App\Models\UserOrder;
use App\Repositories\BaseRepository;
use Aws\ivschat\ivschatClient;
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
        foreach ($carIds as $carId) {
            $orders[] = $this->model::query()->whereIn('car_id', $carId)->with(['defectiveActs' => function (HasOne $q) {
                $q->with(['defectWorks' => function (HasMany $q) {
                    $q->pluck('price_with_markup');
                }]);
            }])->get();
        }

        foreach ($orders as $order) {
            $defectActWorks[] = $order->pluck('defectiveActs')->pluck('defectWorks');
        }
        foreach ($defectActWorks as $index1 => $defectActWork) {
            foreach ($defectActWork as $item) {
                foreach ($serviceNames as $serviceName) {
                    if ($item) {
                        if (in_array($serviceName, $item->pluck('work_name')->toArray())) {
                            $statistic[$index1][] = [
                                'work' => $serviceName,
                                'price' => $item->where('work_name', $serviceName)->first()->price * $item->where('work_name', $serviceName)->first()->amount
                            ];
                        }else {
                            $statistic[$index1][] = [
                                'work' => $serviceName,
                                'price' => '-'

                            ];
                        }
                    }
                }
            }
        }

        return $statistic;
    }
}
