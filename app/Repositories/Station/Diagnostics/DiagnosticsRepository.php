<?php

namespace App\Repositories\Station\Diagnostics;

use App\Http\Controllers\Station\Diagnostics\Data\DiagnosticsData;
use App\Models\Diagnostics;
use App\Models\Order;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DiagnosticsRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Diagnostics::class;
    }

    public function store(DiagnosticsData $data, int $orderId): Diagnostics
    {
        $diagnostics = new Diagnostics();

        $diagnostics->date = Carbon::createFromFormat('d-m-Y', $data->date)->format('Y-m-d');

        $diagnostics->order_id = $orderId;

        $diagnostics->save();

        $order = Order::query()->findOrFail($orderId);

        $order->status = 3; // статус: Назначена диагностика

        $order->save();

        return $diagnostics;
    }
}
