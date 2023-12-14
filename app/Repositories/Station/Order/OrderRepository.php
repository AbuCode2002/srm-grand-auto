<?php

namespace App\Repositories\Station\Order;

use App\Http\Controllers\Station\Order\Data\OrderByStatusData;
use App\Http\Controllers\Station\Order\Data\OrderData;
use App\Models\Order;
use App\Models\Region;
use App\Models\Role;
use App\Models\Status;
use App\Models\UserOrder;
use App\Models\UserToRegion;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

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

        $regionId = UserToRegion::query()
            ->where('user_id', $user->id)
            ->pluck('region_id');

        if ($roleName === 'superAdmin') {

            return $this->model::query()
                ->with('users',
                    'contract',
                    'car',
                    'status',
                    'region',
                    'defectiveActs',
                    'station')
//                ->orderBy('id')
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage, ['*'], 'page', $page);

        } else if ($roleName === 'manager') {

            return $this->model::query()
                ->with('car')
                ->with('users')
                ->with('contract')
                ->with('status')
                ->with('region')
                ->whereIn('region_id', $regionId)
//                ->orderBy('id')
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage, ['*'], 'page', $page);

        } else if ($roleName === 'client') {

            return $this->model::query()
                ->with('car')
                ->with('users')
                ->with('contract')
                ->with('status')
                ->with('region')
                ->whereIn('region_id', $regionId)
//                ->orderBy('id')
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage, ['*'], 'page', $page);
        } else if ($roleName === 'station') {

            return $this->model::query()
                ->with('car')
                ->with('users')
                ->with('contract')
                ->with('status')
                ->with('region')
                ->whereIn('region_id', $regionId)
//                ->orderBy('id')
                ->orderBy('created_at', 'desc')
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

    public function indexByStatus($page, $status)
    {
        $user = Auth::user();

        $roleName = Role::query()->where('id', $user->role_id)->value('name');

        $regionId = UserToRegion::query()
            ->where('user_id', $user->id)
            ->pluck('region_id');

        $statusId = Status::query()->where('name', $status)->value('id');

        if ($roleName === 'superAdmin') {

            return $this->model::query()
                ->with('users',
                    'contract',
                    'car',
                    'status',
                    'region',
                    'station')
                ->where('status', $statusId)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage, ['*'], 'page', $page);
        }

        return $this->model::query()
            ->with('users',
                'contract',
                'car',
                'status',
                'region',
                'station')
            ->where('status', $statusId)
            ->whereIn('region_id', $regionId)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $page);
    }

    public function paidIndex($page)
    {
        $statusId = Status::query()->where('name', 'Заявка закрыта')->value('id');

            return $this->model::query()
                ->with('users',
                    'contract',
                    'car',
                    'status',
                    'region',
                    'station')
                ->where('status', $statusId)
                ->where('paid', 0)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage, ['*'], 'page', $page);
    }

    public function changeStatus(Order $order): void
    {
        $statusId = Status::query()->where('name', 'Проводятся ремонтные работы ')->value('id');

        $order->status = $statusId;

        $order->save();
    }

    public function paidStatus(Order $order, $paid): void
    {
        if ($paid != null) {
            $order->paid = $paid;
        }else {
            $order->paid = 0;
        }

        $order->save();
    }

    public function endWork(Order $order): void
    {
        $statusId = Status::query()->where('name', 'Ремонт выполнен ')->value('id');

        $order->status = $statusId;

        $order->save();
    }

}
