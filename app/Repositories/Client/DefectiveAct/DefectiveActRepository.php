<?php

namespace App\Repositories\Client\DefectiveAct;

use App\Http\Controllers\Client\DefectiveAct\Data\DefectiveActData;
use App\Models\DefectiveAct;
use App\Models\Order;
use App\Models\Service;
use App\Models\SparePart;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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

    public function acwService(int $id)
    {
        return DB::table('defective_acts')
            ->join('services', 'defective_acts.id', '=', 'services.defective_act_id')
            ->join('service_names', 'services.service_name_id', '=', 'service_names.id')

            ->select(
                'service_names.name as service_name',
                DB::raw("DATE_FORMAT(services.created_at, '%d-%m-%Y') as data"),
                'services.unit as unit',
                'services.count as count',
                'services.price as price',
                DB::raw('(services.price * services.count) as price_count'),
                DB::raw('((services.price * services.count) * 0.12) as nds'),
                DB::raw('((services.price * services.count) * 1.12) as price_count_nds')
            )

            ->where('defective_acts.order_id', '=', $id)
            ->get();
    }

    public function acwPart(int $id)
    {
        return DB::table('defective_acts')
            ->join('services', 'defective_acts.id', '=', 'services.defective_act_id')
            ->join('spare_parts', 'services.id', '=', 'spare_parts.service_id')
            ->join('part_names', 'spare_parts.part_name_id', '=', 'part_names.id')

            ->select(
                'part_names.name as part_name',
                DB::raw("DATE_FORMAT(spare_parts.created_at, '%d-%m-%Y') as data"),
                'spare_parts.unit as unit',
                'spare_parts.count as count',
                'spare_parts.price as price',
                DB::raw('(spare_parts.price * spare_parts.count) as price_count'),
                DB::raw('((spare_parts.price * spare_parts.count) * 0.12) as nds'),
                DB::raw('((spare_parts.price * spare_parts.count) * 1.12) as price_count_nds')
            )

            ->where('defective_acts.order_id', '=', $id)
            ->get();
    }
}
