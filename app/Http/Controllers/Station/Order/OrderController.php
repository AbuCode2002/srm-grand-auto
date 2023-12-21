<?php

namespace App\Http\Controllers\Station\Order;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Station\Order\Data\OrderByStatusData;
use App\Http\Controllers\Station\Order\Data\OrderData;
use App\Http\Requests\Order\OrderEditRequest;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Requests\Station\OrderIndexByStatusRequest;
use App\Repositories\Station\Order\OrderRepository;
use App\Transformers\Api\Station\Order\OrderIndexTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

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
     * @param Request $request
     * @return LengthAwarePaginator|null
     */
    public function index(Request $request): ?LengthAwarePaginator
    {
        $page = $request->input('page', 1);

        $orders = $this->orderRepository->index($page);

        return $orders;
    }

    public function indexByStatus(Request $request)
    {
        $page = $request->input('page', 1);

        $status = $request->input('status');

        if ($status === 'all') {
            $order = $this->orderRepository->index($page);
        }elseif ($status === 'Не оплачено') {
            $order = $this->orderRepository->paidIndex($page);
        }else {
            $order = $this->orderRepository->indexByStatus($page, $status);
        }
//        dd($order->pluck('defectiveActs')[0]);
        return $this->setPagination($order)
            ->respondWithSuccess(
            $this->transformCollection($order, new OrderIndexTransformer()),
            "created",
        );
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

    public function  changeStatus(int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);

        $this->orderRepository->changeStatus($order);
    }

    public function  paidStatus(Request $request, int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);

        $paid = array_key_first($request->input());


        $this->orderRepository->paidStatus($order, $paid);
    }

    public function  endWork(int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);

        $this->orderRepository->endWork($order);
    }
}
