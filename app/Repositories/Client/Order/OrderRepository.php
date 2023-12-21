<?php

namespace App\Repositories\Client\Order;

use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Models\Order;
use App\Models\Status;
use App\Models\UserOrder;
use App\Repositories\BaseRepository;
use DateTime;
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
//        $user = Auth::user();

//        $roleName = Role::query()->where('id', $user->role_id)->value('name');

//        if ($roleName === 'client') {

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

//        }
//        else if ($roleName === 'manager') {
//
//            return $this->model::query()
//                ->with('car')
//                ->with('status')
//                ->with('region')
//                ->paginate($this->perPage, ['*'], 'page', $page);
//
//        } else if ($roleName === 'client') {
//
//            return $this->model::query()
//                ->with('car')
//                ->with('status')
//                ->with('region')
//                ->paginate($this->perPage, ['*'], 'page', $page);
//        }
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
        $order->contract_id = $data->contract_id;
        $order->problem_description = $data->problem_description;
        $order->is_broken = $data->is_broken;
        $order->service_type = $data->service_type;
        $order->driver_id = $data->driver_id;
        $order->driver_type = $data->driver_type;
        $order->mileage = $data->mileage;
        $order->status = 1;
        $order->paid = 0;

        $order->save();

        $userOrder = new UserOrder();

        $userOrder->user_id = Auth::user()->id;
        $userOrder->order_id = $order->id;

        $userOrder->save();

        return $order;
    }
public function edit(
    Order $order,
    OrderData $data
    )
    {
        if($data->statusName){
            $data->status = Status::query()->where('name', $data->statusName)->value('id');
        }

        $dateNow = new DateTime();

        $order->car_id = $data->car_id ? $data->car_id : $order->car_id;
        $order->region_id = $data->region_id ? $data->region_id : $order->region_id;
        $order->contract_id = $data->contract_id ? $data->contract_id : $order->contract_id;
        $order->problem_description = $data->problem_description ? $data->problem_description : $order->problem_description;
        $order->is_broken = $data->is_broken ? $data->is_broken : $order->is_broken;
        $order->service_type = $data->service_type ? $data->service_type : $order->service_type;
        $order->driver_id = $data->driver_id ? $data->driver_id : $order->driver_id;
        $order->driver_type = $data->driver_type ? $data->driver_type : $order->driver_type;
        $order->mileage = $data->mileage ? $data->mileage : $order->mileage;
        $order->station_id = $data->station_id ? $data->station_id : $order->station_id;
        $order->status = $data->status ? $data->status : $order->status;

        if (date_diff($dateNow, $order->created_at)->h < 24) {
            $order->kpi1 =  1;
        }

        $order->save();

        return $order;
    }

    public function show(int $id)
    {
        return $this->model::query()->where('id', $id)->get();
    }
}
