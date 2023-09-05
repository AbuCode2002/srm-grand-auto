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

    public function index() {
        $orders = $this->orderRepository->index();

        return $orders;
    }

    /**
     * @param OrderStoreRequest $request
     * @return mixed
     */
    public function store(OrderStoreRequest $request)
    {
        $data = OrderData::from($request->validated());

        $orders = $this->orderRepository->store($data);

            return $this->respondWithSuccess(
                $this->transformCollection($orders, new OrderIndexTransformer),
                'created',
            );
    }

    public function show()
    {
        $order = $this->orderRepository->show();

        return $this->respondWithSuccess(
        $this->transformCollection($order, new OrderIndexTransformer()),
        "created",
    );
    }
}
