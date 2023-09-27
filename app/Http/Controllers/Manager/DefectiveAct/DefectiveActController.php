<?php

namespace App\Http\Controllers\Manager\DefectiveAct;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Manager\DefectiveAct\Data\DefectiveActData;
use App\Http\Requests\DefectiveAct\DefectiveActRequest;
use App\Models\Order;
use App\Repositories\Manager\DefectiveAct\DefectiveActRepository;
use App\Repositories\Manager\Order\OrderRepository;
use App\Transformers\Api\Manager\DefectiveAct\DefectiveActIndexTransformer;
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

            return $this->respondWithSuccess(
                $this->transformItem($defectiveAct, new DefectiveActIndexTransformer()),
                "created",
            );
    }
}
