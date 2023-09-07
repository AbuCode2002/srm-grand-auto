<?php

namespace App\Repositories\Client\Order;

use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Models\Order;
use App\Models\Role;
use App\Models\UserOrder;
use App\Models\UserToRegion;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

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

    public function show()
    {
        $userId = Auth::user()->id;

        $regionId = UserToRegion::query()->where('user_id', $userId)->pluck('region_id')->toArray();

        $order = $this->model::query()->whereIn('region_id', $regionId);

        return $order;
    }
}
