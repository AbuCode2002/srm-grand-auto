<?php

namespace App\Http\Controllers\Admin\CarStatistic;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CarStatistic\CarStatisticRequest;
use App\Repositories\Admin\Car\CarRepository;
use App\Repositories\Admin\Order\OrderRepository;
use App\Repositories\Admin\ServiceName\ServiceNameRepository;

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
        $serviceName = $this->serviceNameRepository->getAll()->pluck('name');
        if (!empty($request->input())) {
            $data = CarStatisticData::from($request->validated());


            $carIds = $this->carRepository->carIds($data);

            $statistics = $this->orderRepository->sumDefectAct($carIds, $serviceName);

            return response()->json($statistics, 200, [], JSON_FORCE_OBJECT);
        }else {
            foreach ($serviceName as $value)
                $service[] = ['name' => $value];
            return  $service;
        }
    }
}
