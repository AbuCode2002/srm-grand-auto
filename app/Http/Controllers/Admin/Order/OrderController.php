<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\Order\Data\OrderData;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Order\OrderEditRequest;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Repositories\Admin\Order\OrderRepository;
use App\Transformers\Api\Admin\Order\OrderIndexTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $orders = $this->orderRepository->index($page);

        return $orders;
    }

    /**
     * @param OrderStoreRequest $request
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $request)
    {
        $data = OrderData::from($request->validated());

        $order = $this->orderRepository->store($data);

            return $this->respondWithSuccess(
                $this->transformItem($order, new OrderIndexTransformer),
                'created',
            );
    }

    public function edit(OrderEditRequest $request)
    {
        $data = OrderData::from($request->validated());

        $order = $this->orderRepository->findById($data->id);

        $order = $this->orderRepository->edit($order, $data);

            return $this->respondWithSuccess(
                $this->transformItem($order, new OrderIndexTransformer),
                'created',
            );
    }

    public function show(int $id)
    {
        $order = $this->orderRepository->show($id);

        return $this->respondWithSuccess(
        $this->transformCollection($order, new OrderIndexTransformer()),
        "created",
    );
    }
}
