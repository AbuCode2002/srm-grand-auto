<?php

namespace App\Http\Controllers\Client\Order;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Http\Requests\OrderStoreRequest;
use App\Repositories\Client\Order\OrderRepository;
use App\Transformers\Api\Client\Order\OrderIndexTransformer;

class OrderController extends BaseController
{
    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        private OrderRepository $orderRepository = new OrderRepository(),
    )
    {
        //
    }

    /**
     * @param OrderStoreRequest $request
     * @return mixed
     */
    public function store(OrderStoreRequest $request)
    {
        $data = OrderData::from($request->validated());

        $order = $this->orderRepository->storeOrder($data);

        return $this->respondWithSuccess(
            $this->transformItem($order, new OrderIndexTransformer()),
            "created",
        );
    }
}
