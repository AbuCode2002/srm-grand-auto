<?php

namespace App\Http\Controllers\Admin\CarStatistic;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CarStatistic\CarStatisticRequest;
use App\Repositories\Admin\Car\CarRepository;
use App\Repositories\Admin\Order\OrderRepository;
use App\Repositories\Admin\ServiceName\ServiceNameRepository;
use App\Transformers\Api\Admin\Car\CarIndexTransformer;

class CarStatisticController extends BaseController
{
    public function __construct(
        private CarRepository $carRepository = new CarRepository(),
        private OrderRepository $orderRepository = new OrderRepository(),
        private ServiceNameRepository $serviceNameRepository = new ServiceNameRepository(),
    )
    {
        //
    }

    public function sumDefectiveActWorkForCar(CarStatisticRequest $request)
    {
        $data = CarStatisticData::from($request->validated());

        $serviceName = $this->serviceNameRepository->getAll()->pluck('name');

        $carIds = $this->carRepository->carIds($data);

        $statistic = $this->orderRepository->sumDefectAct($carIds, $serviceName);

            return $this->respondWithSuccess(
                $this->transformCollection($statistic, new CarIndexTransformer()),
                "created",
            );
    }
}
