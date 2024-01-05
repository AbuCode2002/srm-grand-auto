<?php

namespace App\Http\Controllers\Client\ACW;

use App\Http\Controllers\BaseController;
use App\Mail\SendFileWithMail;
use App\Models\Order;
use App\Repositories\Client\DefectiveAct\DefectiveActRepository;
use App\Repositories\Client\Order\OrderRepository;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;
use Mnvx\Lowrapper\Converter;
use Mnvx\Lowrapper\Format;
use Mnvx\Lowrapper\LowrapperParameters;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ACWController extends BaseController
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

    public function ACW(int $orderId)
    {
        $acw1 = $this->orderRepository->acw1($orderId);
        $acwService = $this->defectiveActRepository->acwService($orderId);
        $acwPart = $this->defectiveActRepository->acwPart($orderId);

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue([2, 1], 'Заявка');
        $spreadsheet->getActiveSheet()->setCellValue([3, 1], 'Автомобиль');
        $spreadsheet->getActiveSheet()->setCellValue([4, 1], 'Заказчик');
        $spreadsheet->getActiveSheet()->setCellValue([5, 1], 'Номерной знак');
        $spreadsheet->getActiveSheet()->setCellValue([6, 1], 'VIN');
        $spreadsheet->getActiveSheet()->setCellValue([7, 1], 'Пробег');

        $spreadsheet->getActiveSheet()->setCellValue([2, 2], ($acw1[0]->order_id != null) ? $acw1[0]->order_id : '-');
        $spreadsheet->getActiveSheet()->setCellValue([3, 2], ($acw1[0]->car != null) ? $acw1[0]->car : '-');
        $spreadsheet->getActiveSheet()->setCellValue([4, 2], ($acw1[0]->company_name != null) ? $acw1[0]->company_name : '-');
        $spreadsheet->getActiveSheet()->setCellValue([5, 2], ($acw1[0]->car_number != null) ? $acw1[0]->car_number : '-');
        $spreadsheet->getActiveSheet()->setCellValue([6, 2], ($acw1[0]->car_vin != null) ? $acw1[0]->car_vin : '-');
        $spreadsheet->getActiveSheet()->setCellValue([7, 2], ($acw1[0]->mileage != null) ? $acw1[0]->mileage : '-');

        $spreadsheet->getActiveSheet()->setCellValue('B4', 'Номер по порядку');
        $spreadsheet->getActiveSheet()->getStyle('B4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('C4', 'Наименование работ (услуг)(в разрезе их подвидов в соответсвийс технической спецификаций, заданием,графиком выполнения работ (услуг) при их наличий)');
        $spreadsheet->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getRowDimension(4)->setRowHeight(130);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);

        $spreadsheet->getActiveSheet()->setCellValue('D4', 'Дата выполнения работ (оказания услуг)');
        $spreadsheet->getActiveSheet()->getStyle('D4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('E4', 'Единица измерения');
        $spreadsheet->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('F4', 'Колличество');
        $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('G4', 'Цена за единицу без НДС (тенге)');
        $spreadsheet->getActiveSheet()->getStyle('G4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('H4', 'Стоимость без НДС(тенге)');
        $spreadsheet->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('I4', 'Сумма НДС(тенге)');
        $spreadsheet->getActiveSheet()->getStyle('I4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->setCellValue('J4', 'Стоимость с учетом НДС(тенге)');
        $spreadsheet->getActiveSheet()->getStyle('J4')->getAlignment()->setWrapText(true);


        $spreadsheet->getActiveSheet()->setCellValue([3, 5], 'Услуга');
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, 5)->getFont()->setBold(true);

        $indexForPart = 0; // Нужен что бы узнать когда начьнеться поле для part

        $allPriceNotNDS = 0;
        $allPriceNotNDSWithCount = 0;

        // Услуга
        foreach ($acwService as $index => $value) {
            $spreadsheet->getActiveSheet()->setCellValue([2, $index + 6], $index + 1);
            $spreadsheet->getActiveSheet()->setCellValue([3, $index + 6], ($value->service_name != null) ? $value->service_name : '-');
            $spreadsheet->getActiveSheet()->setCellValue([4, $index + 6], ($value->data != null) ? $value->data : '-');
            $spreadsheet->getActiveSheet()->setCellValue([5, $index + 6], ($value->unit != null) ? $value->unit : '-');
            $spreadsheet->getActiveSheet()->setCellValue([6, $index + 6], ($value->count != null) ? $value->count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([7, $index + 6], ($value->price != null) ? $value->price : '-');
            $spreadsheet->getActiveSheet()->setCellValue([8, $index + 6], ($value->price_count != null) ? $value->price_count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([9, $index + 6], ($value->nds != null) ? $value->nds : '-');
            $spreadsheet->getActiveSheet()->setCellValue([10, $index + 6], ($value->price_count_nds != null) ? $value->price_count_nds : '-');

            $allPriceNotNDS += $value->price;
            $allPriceNotNDSWithCount += $value->price_count;

            $indexForPart = $index + 6;
        }

        $spreadsheet->getActiveSheet()->setCellValue([3, $indexForPart + 1], 'Материалы');
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $indexForPart + 1)->getFont()->setBold(true);

        $indexForPrice = 0; // Нужен что бы узнать когда начнеться поле для итога

        //Материалы
        foreach ($acwPart as $index => $value) {
            $spreadsheet->getActiveSheet()->setCellValue([2, $indexForPart + $index + 2], $indexForPart - 4);
            $spreadsheet->getActiveSheet()->setCellValue([3, $indexForPart + $index + 2], ($value->part_name != null) ? $value->part_name : '-');
            $spreadsheet->getActiveSheet()->setCellValue([4, $indexForPart + $index + 2], ($value->data != null) ? $value->data : '-');
            $spreadsheet->getActiveSheet()->setCellValue([5, $indexForPart + $index + 2], ($value->unit != null) ? $value->unit : '-');
            $spreadsheet->getActiveSheet()->setCellValue([6, $indexForPart + $index + 2], ($value->count != null) ? $value->count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([7, $indexForPart + $index + 2], ($value->price != null) ? $value->price : '-');
            $spreadsheet->getActiveSheet()->setCellValue([8, $indexForPart + $index + 2], ($value->price_count != null) ? $value->price_count : '-');
            $spreadsheet->getActiveSheet()->setCellValue([9, $indexForPart + $index + 2], ($value->nds != null) ? $value->nds : '-');
            $spreadsheet->getActiveSheet()->setCellValue([10, $indexForPart + $index + 2], ($value->price_count_nds != null) ? $value->price_count_nds : '-');

            $indexForPrice = $indexForPart + $index + 2;
            $allPriceNotNDS += $value->price;
            $allPriceNotNDSWithCount += $value->price_count;
        }

        $spreadsheet->getActiveSheet()->setCellValue([3, $indexForPrice + 1], 'Итого:');
        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $indexForPrice + 1)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue([7, $indexForPrice + 1], $allPriceNotNDS);
        $spreadsheet->getActiveSheet()->setCellValue([8, $indexForPrice + 1], $allPriceNotNDSWithCount);
        $spreadsheet->getActiveSheet()->setCellValue([9, $indexForPrice + 1], $allPriceNotNDSWithCount * 0.12);
        $spreadsheet->getActiveSheet()->setCellValue([10, $indexForPrice + 1], $allPriceNotNDSWithCount * 1.12);

        $spreadsheet->getActiveSheet()->mergeCells('E' . $indexForPrice + 9 - 4 . ':' . 'I' . $indexForPrice + 9 - 4);
        $spreadsheet->getActiveSheet()->mergeCells('E' . $indexForPrice + 10 - 4 . ':' . 'I' . $indexForPrice + 10 - 4);
        $spreadsheet->getActiveSheet()->mergeCells('E' . $indexForPrice + 11 - 4 . ':' . 'I' . $indexForPrice + 11 - 4);
        $spreadsheet->getActiveSheet()->mergeCells('E' . $indexForPrice + 12 - 4 . ':' . 'J' . $indexForPrice + 12 - 4);

        $spreadsheet->getActiveSheet()->setCellValue('E' . $indexForPrice + 7 - 2, 'Приняли:');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $indexForPrice + 9 - 3, 'Региональный директор ___________');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $indexForPrice + 10 - 3, 'Началник УТО                ___________');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $indexForPrice + 11 - 3, 'Механик по ремонту      ___________');
        $spreadsheet->getActiveSheet()->setCellValue('E' . $indexForPrice + 12 - 3, 'Водитель автотранспортного средства _______________');

        $styleBordersArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['rgb' => '000000'], // Цвет границы (в данном случае, жирный черный)
                ],
            ],
        ];

        $styleBordersArray1 = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Цвет границы (в данном случае, тонкий черный)
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle("B" . (1) . ":G" . (1))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("C" . (1) . ":F" . (2))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("D" . (1) . ":E" . (2))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("D" . (1) . ":D" . (2))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("B" . (1) . ":G" . (2))->applyFromArray($styleBordersArray, True);

        $spreadsheet->getActiveSheet()->getStyle("B" . (4) . ":J" . (4))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("B" . (6) . ":J" . (6))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("B" . (7) . ":J" . (7))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("B" . (8) . ":J" . (8))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("B" . (4) . ":J" . (9))->applyFromArray($styleBordersArray1, True);

        $spreadsheet->getActiveSheet()->getStyle("C" . (4) . ":J" . (9))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("D" . (4) . ":I" . (9))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("E" . (4) . ":H" . (9))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("F" . (4) . ":G" . (9))->applyFromArray($styleBordersArray1, True);
        $spreadsheet->getActiveSheet()->getStyle("F" . (4) . ":F" . (9))->applyFromArray($styleBordersArray1, True);

        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation('landscape');

        $drawing = new Drawing();
        $drawing->setName('pechat');
        $drawing->setDescription('pechat');
        $drawing->setPath(__DIR__ . '/../../../../../public/assets/images/печать.jpeg');
        $drawing->setCoordinates('B13');
        $spreadsheet->getActiveSheet()->mergeCells('B13:D13');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $tempFilePath = tempnam(sys_get_temp_dir(), 'excel_');

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFilePath);

        $converter = new Converter();

        $pdfTempFilePath = tempnam(sys_get_temp_dir(), 'pdf');

        $parameters = (new LowrapperParameters())
            ->setInputFile($tempFilePath)
            // В каком формате нужен результат
            ->setOutputFormat(Format::TEXT_PDF)
            // Файл для сохранения результата
            ->setOutputFile($pdfTempFilePath);

        $converter->convert($parameters);

        $response = new BinaryFileResponse($pdfTempFilePath);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'filename="название_файла.pdf"');

        Mail::raw('АВР', function ($mail) use ($pdfTempFilePath, $orderId) {
            $mail->to('auto-transport.auto@yandex.ru')
                ->subject('Отправка АВР')
                ->attach($pdfTempFilePath, [
                    'as' => 'АВР_'. $orderId .'.pdf', // Опционально: задает имя файла вложения
                ]);
        });

        return $response;
    }
}
