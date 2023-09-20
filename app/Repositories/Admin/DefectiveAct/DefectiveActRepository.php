<?php

namespace App\Repositories\Admin\DefectiveAct;

use App\Http\Controllers\Admin\DefectiveAct\Data\DefectiveActData;
use App\Models\DefectiveAct;
use App\Models\Order;
use App\Models\Service;
use App\Models\SparePart;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

        $defectiveAct = new DefectiveAct();

        $defectiveAct->order_id = $order->id;

        $defectiveAct->total = $data->total;

        $defectiveAct->markup = $markup;

        $defectiveAct->total_with_markup = $data->total/(1 - ($markup/100));

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

        return $defectiveAct;
    }
}
