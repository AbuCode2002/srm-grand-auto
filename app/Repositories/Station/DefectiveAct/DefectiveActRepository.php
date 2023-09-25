<?php

namespace App\Repositories\Station\DefectiveAct;

use App\Http\Controllers\Station\DefectiveAct\Data\DefectiveActData;
use App\Models\DefectiveAct;
use App\Models\Order;
use App\Models\Service;
use App\Models\SparePart;
use App\Models\UserToRegion;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use function Clue\StreamFilter\fun;

class DefectiveActRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = DefectiveAct::class;
    }

    /**
     * @param DefectiveActData $data
     * @param Order $order
     * @return DefectiveAct
     */
    public function store(DefectiveActData $data, Order $order): DefectiveAct
    {
        $markup = Order::query()
            ->where('id', $order->id)
            ->with(['contract' => function (BelongsTo $q) {
                $q->with(['company' => function (BelongsTo $q) {
                    $q->value('markup');
                }]);
            }])
            ->getRelation('contract')
            ->getRelation('company')
            ->value('markup');

        $defectiveActForOrder = $this->show($order->id);

        $defectiveAct = new DefectiveAct();

        if (!$defectiveActForOrder) {

            $defectiveAct->order_id = $order->id;

            $defectiveAct->total = $data->total;

            $defectiveAct->markup = $markup;

            $defectiveAct->total_with_markup = $data->total / (1 - ($markup / 100));

            $defectiveAct->sum_sale = $data->total_procent;

            $defectiveAct->save();

            foreach (array_keys($data->service) as $item) {

                $service = new Service();

                $service->defective_act_id = $defectiveAct->id;

                $service->name = $data->service[$item]["name"]["name"];

                $service->count = $data->service[$item]["count"];

                $service->unit = $data->service[$item]["unit"]["unitName"];

                $service->price = $data->service[$item]["price"];

                $service->sale_percent = $data->service[$item]["sale_percent"];

                $service->save();

                foreach (array_keys($data->spare_parts[$item]) as $value) {

                    $sparePart = new SparePart();

                    $sparePart->service_id = $service->id;

                    $sparePart->name = $data->spare_parts[$item][$value]["name"]["name"];

                    $sparePart->count = $data->spare_parts[$item][$value]["count"];

                    $sparePart->unit = $data->spare_parts[$item][$value]["unit"]["unitName"];

                    $sparePart->price = $data->spare_parts[$item][$value]["price"];

                    $sparePart->sale_percent = $data->spare_parts[$item][$value]["sale_percent"];

                    $sparePart->save();
                }
            }
        } else {
            foreach (array_keys($data->service) as $item) {

//                $service = Service::query()->findOrFail($data->service[$item]["id"]);
                $service = Service::query()->findOrNew($data->service[$item]["id"], [

                ]);

                if ($service) {

                    $service->name = $data->service[$item]["name"]["name"];
                    $service->count = $data->service[$item]["count"];
                    $service->unit = $data->service[$item]["unit"]["unitName"];
                    $service->price = $data->service[$item]["price"];
                    $service->sale_percent = $data->service[$item]["sale_percent"];

                    $service->save();
                } else {
                    $serviceModel = new Service();

                    $serviceModel->defective_act_id = $service->defective_act_id;
                    $serviceModel->name = $data->service[$item]["name"]["name"];
                    $serviceModel->count = $data->service[$item]["count"];
                    $serviceModel->unit = $data->service[$item]["unit"]["unitName"];
                    $serviceModel->price = $data->service[$item]["price"];
                    $serviceModel->sale_percent = $data->service[$item]["sale_percent"];

                    $serviceModel->save();
                }

                foreach (array_keys($data->spare_parts[$item]) as $value) {

                    $part = SparePart::query()->findOrFail($data->spare_parts[$item][$value]["id"]);

                    if ($part) {
                        $part->name = $data->spare_parts[$item][$value]["name"]["name"];
                        $part->count = $data->spare_parts[$item][$value]["count"];
                        $part->unit = $data->spare_parts[$item][$value]["unit"]["unitName"];
                        $part->price = $data->spare_parts[$item][$value]["price"];
                        $part->sale_percent = $data->spare_parts[$item][$value]["sale_percent"];

                        $part->save();
                    } else {
                        $partModel = new SparePart();

                        $partModel->defective_act_id = $part->defective_act_id;
                        $partModel->name = $data->spare_parts[$item][$value]["name"]["name"];
                        $partModel->count = $data->spare_parts[$item][$value]["count"];
                        $partModel->unit = $data->spare_parts[$item][$value]["unit"]["unitName"];
                        $partModel->price = $data->spare_parts[$item][$value]["price"];
                        $partModel->sale_percent = $data->spare_parts[$item][$value]["sale_percent"];

                        $partModel->save();
                    }
                }
            }

        }
        return $defectiveAct;
    }

    /**
     * @return Builder[]|Collection
     */
    public function index()
    {
        $userId = Auth::id();

        $regionId = UserToRegion::query()->where('user_id', $userId)->pluck('region_id');

        return $this->model::query()
            ->whereHas('order', function ($q) use ($regionId) {
                $q->whereIn('region_id', $regionId);
            })
            ->get();
    }

    /**
     * @param int $orderId
     * @return Builder[]|Collection
     */
    public function show(int $orderId)
    {
        return $this->model::query()->with(['service' => function (HasMany $q) {
            $q->with('sparePart');
        }])->where('order_id', $orderId)->get();
    }
}
