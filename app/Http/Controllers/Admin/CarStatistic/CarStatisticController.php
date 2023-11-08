<?php

namespace App\Http\Controllers\Admin\CarStatistic;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CarStatistic\CarStatisticRequest;
use App\Repositories\Admin\Car\CarRepository;
use App\Repositories\Admin\Order\OrderRepository;
use App\Transformers\Api\Admin\Car\CarIndexTransformer;

class CarStatisticController extends BaseController
{
    public function __construct(
        private CarRepository $carRepository = new CarRepository(),
        private OrderRepository $orderRepository = new OrderRepository(),
    )
    {
        //
    }

    public function sumDefectiveActWorkForCar(CarStatisticRequest $request)
    {
        $data = CarStatisticData::from($request->validated());

        $car = $this->carRepository->carIds($data);

        dd($car);
        $order = $this->orderRepository->sumDefectAct($car);

            return $this->respondWithSuccess(
                $this->transformCollection($car, new CarIndexTransformer()),
                "created",
            );
    }
}
