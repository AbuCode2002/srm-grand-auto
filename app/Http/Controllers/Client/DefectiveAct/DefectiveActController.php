<?php

namespace App\Http\Controllers\Client\DefectiveAct;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Client\DefectiveAct\Data\DefectiveActData;
use App\Http\Requests\DefectiveAct\DefectiveActRequest;
use App\Models\Order;
use App\Repositories\Client\DefectiveAct\DefectiveActRepository;
use App\Repositories\Client\Order\OrderRepository;
use App\Transformers\Api\Client\DefectiveAct\DefectiveActIndexTransformer;
use Illuminate\Http\JsonResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
}
