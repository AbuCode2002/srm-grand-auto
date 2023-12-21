<?php

namespace App\Http\Controllers\Station\DefectiveAct;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Station\DefectiveAct\Data\DefectiveActData;
use App\Http\Requests\DefectiveAct\DefectiveActRequest;
use App\Models\Order;
use App\Models\Status;
use App\Repositories\Station\DefectiveAct\DefectiveActRepository;
use App\Repositories\Station\Order\OrderRepository;
use App\Transformers\Api\Station\DefectiveAct\DefectiveActIndexTransformer;
use Illuminate\Http\JsonResponse;

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

        $this->orderRepository->editStatus($orderId);

        return $this->respondWithSuccess(
                $this->transformItem($defectiveAct, new DefectiveActIndexTransformer()),
                "created",
            );
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $defectiveAct = $this->defectiveActRepository->index();

        return $this->respondWithSuccess(
            $this->transformCollection($defectiveAct, new DefectiveActIndexTransformer()),
            "created",
        );
    }

    /**
     * @param int $orderId
     * @return JsonResponse
     */
    public function show(int $orderId): JsonResponse
    {
        $defectiveAct = $this->defectiveActRepository->show($orderId);

        return $this->respondWithSuccess(
            $this->transformCollection($defectiveAct, new DefectiveActIndexTransformer()),
            "created",
        );
    }
}
