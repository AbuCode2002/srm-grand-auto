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
use phpDocumentor\Reflection\Types\Collection;

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
        $order->service_type = $data->service_type;
        $order->driver_type = $data->driver_type;
        $order->mileage = $data->mileage;
        $order->is_broken = $data->is_broken;
        $order->region_id = $data->region_id;
        $order->driver_id = $data->driver_id;
        $order->problem_description = $data->problem_description;
        $order->status = 1;
        $order->contract_id = $data->contract_id;

        $order->paid = 0;

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
        if ($data->statusName) {
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
            $order->kpi1 = 1;
        }

        $order->save();

        return $order;
    }

    public function show(int $id)
    {
        return $this->model::query()->where('id', $id)->get();
    }

    public function acw1(int $id)
    {
        return DB::table('orders')
            ->join('defective_acts', 'orders.id', '=', 'defective_acts.order_id')
            ->join('cars', 'orders.car_id', '=', 'cars.id')
            ->join('contracts', 'orders.contract_id', '=', 'contracts.id')
            ->join('companies', 'companies.id', '=', 'contracts.company_id')
            ->select('orders.id as order_id',
                DB::raw("CONCAT(cars.brand, ' ', cars.model) as car"),
                'companies.name as company_name',
                'cars.number as car_number',
                'cars.vin_number as car_vin',
                'orders.mileage')
            ->where('orders.id', '=', $id)
            ->get();
    }

    public function acw(int $id)
    {
        $query1 = DB::table('orders')
            ->join('defective_acts', 'orders.id', '=', 'defective_acts.order_id')
            ->join('cars', 'orders.car_id', '=', 'cars.id')
            ->select('orders.id', DB::raw("CONCAT(cars.brand, ' ', cars.model)"),'orders.service_type','orders.mileage','orders.problem_description')
            ->where('orders.id', '=', $id);

        $query2 = DB::table('defective_acts')
        ->join('services', 'defective_acts.id', '=', 'services.defective_act_id')
        ->join('service_names', 'services.service_name_id', '=', 'service_names.id')

        ->select(
            'service_names.name', 'services.created_at', 'services.unit', 'services.count',
            'services.price',
            DB::raw('(services.price * services.count)'),
            DB::raw('((services.price * services.count) * 0.12)'),
            DB::raw('((services.price * services.count) * 1.12)')
        )
        ->where('defective_acts.order_id', '=', $id);

        return $query1->union($query2)->get();
    }
}
