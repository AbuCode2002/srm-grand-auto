<?php

namespace App\Http\Controllers\Client\DefectiveAct;

use App\Exports\ACW1Export;
use App\Exports\ACW2Export;
use App\Exports\MergedExport;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Client\DefectiveAct\Data\DefectiveActData;
use App\Http\Requests\DefectiveAct\DefectiveActRequest;
use App\Models\Order;
use App\Repositories\Client\DefectiveAct\DefectiveActRepository;
use App\Repositories\Client\Order\OrderRepository;
use App\Transformers\Api\Client\DefectiveAct\DefectiveActIndexTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DefectiveActController extends BaseController
{
        /**
     * @param DefectiveActRepository $defectiveActRepository
     * @param Order|OrderRepository $orderRepository
     */
    public function __construct(
        private DefectiveActRepository $defectiveActRepository = new DefectiveActRepository(),
        private Order|OrderRepository  $orderRepository = new OrderRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function store(int $orderId, DefectiveActRequest $defectiveActRequest)
    {
        $data = DefectiveActData::from($defectiveActRequest->validated());

        $order = $this->orderRepository->findById($orderId);

        $defectiveAct = $this->defectiveActRepository->store($data, $order);

        return $this->respondWithSuccess(
            $this->transformItem($defectiveAct, new DefectiveActIndexTransformer()),
            "created",
        );
    }

    public function ACW(int $orderId)
    {
        $acw1 = $this->orderRepository->acw1($orderId);
        $acwService = $this->defectiveActRepository->acwService($orderId);
        $acwPart = $this->defectiveActRepository->acwPart($orderId);

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue([1, 1], 'Заявка');
        $spreadsheet->getActiveSheet()->setCellValue([2, 1], 'Автомобиль');
        $spreadsheet->getActiveSheet()->setCellValue([3, 1], 'Заказчик');
        $spreadsheet->getActiveSheet()->setCellValue([4, 1], 'Номерной знак');
        $spreadsheet->getActiveSheet()->setCellValue([5, 1], 'VIN');
        $spreadsheet->getActiveSheet()->setCellValue([6, 1], 'Пробег');

        $spreadsheet->getActiveSheet()->setCellValue([1, 2], ($acw1[0]->order_id != null) ? $acw1[0]->order_id : '-');
        $spreadsheet->getActiveSheet()->setCellValue([2, 2], ($acw1[0]->car != null) ? $acw1[0]->car : '-');
        $spreadsheet->getActiveSheet()->setCellValue([3, 2], ($acw1[0]->company_name != null) ? $acw1[0]->company_name : '-');
        $spreadsheet->getActiveSheet()->setCellValue([4, 2], ($acw1[0]->car_number != null) ? $acw1[0]->car_number : '-');
        $spreadsheet->getActiveSheet()->setCellValue([5, 2], ($acw1[0]->car_vin != null) ? $acw1[0]->car_vin : '-');
        $spreadsheet->getActiveSheet()->setCellValue([6, 2], ($acw1[0]->mileage != null) ? $acw1[0]->mileage : '-');

        $spreadsheet->getActiveSheet()->setCellValue([1, 4], 'Номер по порядку');
        $spreadsheet->getActiveSheet()->setCellValue([2, 4], 'Наименование работ (услуг)
                                                                    (в разрезе их подвидов в соответсвий
                                                                    с технической спецификаций, заданием,
                                                                    графиком выполнения работ (услуг) при их наличий)');
        $spreadsheet->getActiveSheet()->setCellValue([3, 4], 'Дата выполнения работ (оказания услуг)**');
        $spreadsheet->getActiveSheet()->setCellValue([4, 4], 'Единица измерения');
        $spreadsheet->getActiveSheet()->setCellValue([5, 4], 'Колличество (час)');
        $spreadsheet->getActiveSheet()->setCellValue([6, 4], 'Цена за единицу без НДС (тенге)');
        $spreadsheet->getActiveSheet()->setCellValue([7, 4], 'Стоимость без НДС(тенге)');
        $spreadsheet->getActiveSheet()->setCellValue([8, 4], 'Сумма НДС(тенге)');
        $spreadsheet->getActiveSheet()->setCellValue([9, 4], 'Стоимость с учетом НДС(тенге)');

        $spreadsheet->getActiveSheet()->setCellValue([2, 5], 'Услуга');
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, 5)->getFont()->setBold(true);


        $indexForPart = 0; // Нужен что бы узнать когда начьнеться поле для part

        $allPriceNotNDS = 0;
        $allPriceNotNDSWithCount = 0;

        // Услуга
        foreach ($acwService as $index => $value) {
            $spreadsheet->getActiveSheet()->setCellValue([1, $index + 6], $index + 1);
            $spreadsheet->getActiveSheet()->setCellValue([2, $index + 6], ($value->service_name != null) ? $value->service_name : '-');
            $spreadsheet->getActiveSheet()->setCellValue([3, $index + 6], ($value->data != null) ? $value->data : '-');
            $spreadsheet->getActiveSheet()->setCellValue([4, $index + 6], ($value->unit != null) ? $value->unit : '-');
            $spreadsheet->getActiveSheet()->setCellValue([5, $index + 6], ($value->count != null) ? $value->count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([6, $index + 6], ($value->price != null) ? $value->price : '-');
            $spreadsheet->getActiveSheet()->setCellValue([7, $index + 6], ($value->price_count != null) ? $value->price_count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([8, $index + 6], ($value->nds != null) ? $value->nds : '-');
            $spreadsheet->getActiveSheet()->setCellValue([9, $index + 6], ($value->price_count_nds != null) ? $value->price_count_nds : '-');

            $allPriceNotNDS += $value->price;
            $allPriceNotNDSWithCount += $value->price_count;

            $indexForPart = $index + 6;
        }

        $spreadsheet->getActiveSheet()->setCellValue([2, $indexForPart + 1], 'Материалы');
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $indexForPart + 1)->getFont()->setBold(true);

        $indexForPrice = 0; // Нужен что бы узнать когда начьнеться поле для итога

        //Материалы
        foreach ($acwPart as $index => $value) {
            $spreadsheet->getActiveSheet()->setCellValue([1, $indexForPart + $index + 2], $indexForPart - 4);
            $spreadsheet->getActiveSheet()->setCellValue([2, $indexForPart + $index + 2], ($value->part_name != null) ? $value->part_name : '-');
            $spreadsheet->getActiveSheet()->setCellValue([3, $indexForPart + $index + 2], ($value->data != null) ? $value->data : '-');
            $spreadsheet->getActiveSheet()->setCellValue([4, $indexForPart + $index + 2], ($value->unit != null) ? $value->unit : '-');
            $spreadsheet->getActiveSheet()->setCellValue([5, $indexForPart + $index + 2], ($value->count != null) ? $value->count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([6, $indexForPart + $index + 2], ($value->price != null) ? $value->price : '-');
            $spreadsheet->getActiveSheet()->setCellValue([7, $indexForPart + $index + 2], ($value->price_count != null) ? $value->price_count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([8, $indexForPart + $index + 2], ($value->nds != null) ? $value->nds : '-');
            $spreadsheet->getActiveSheet()->setCellValue([9, $indexForPart + $index + 2], ($value->price_count_nds != null) ? $value->price_count_nds : '-');

            $indexForPrice = $indexForPart + $index + 2;
            $allPriceNotNDS += $value->price;
            $allPriceNotNDSWithCount += $value->price_count;
        }

        $spreadsheet->getActiveSheet()->setCellValue([2, $indexForPrice + 1], 'Итого:');
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $indexForPrice + 1)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue([6, $indexForPrice + 1], $allPriceNotNDS);
        $spreadsheet->getActiveSheet()->setCellValue([7, $indexForPrice + 1], $allPriceNotNDSWithCount);
        $spreadsheet->getActiveSheet()->setCellValue([8, $indexForPrice + 1], $allPriceNotNDSWithCount * 0.12);
        $spreadsheet->getActiveSheet()->setCellValue([9, $indexForPrice + 1], $allPriceNotNDSWithCount * 1.12);

        $drawing = new Drawing();
        $drawing->setName('pechat');
        $drawing->setDescription('pechat');
        $drawing->setPath(__DIR__ . '/../../../../../public/assets/images/pechat.png');
        $drawing->setHeight(36);
        $drawing->setCoordinates('D24');
        $drawing->setOffsetX(10);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
//        $spreadsheet->getActiveSheet()->setCellValue([1 ,$indexForPrice + 2],);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel_');

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFilePath);

        $response = new BinaryFileResponse($tempFilePath);

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="название_файла.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
