<?php

namespace App\Repositories\Client\Order;

use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Models\Order;
use App\Models\UserToRegion;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Order::class;
    }

    public function index() {
        return $this->model::query()->paginate($this->perPage);
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
        $order->client_id = $data->client_id;
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

        return $order;
    }

    public function show()
    {
        $userId = Auth::user()->id;

        $regionId = UserToRegion::query()->where('user_id', $userId)->pluck('region_id')->toArray();

        $order = $this->model::query()->whereIn('region_id', $regionId);

        return $order;
    }
}
