<?php

namespace App\Http\Controllers\Admin\CarStatistic;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Statistic\CarStatisticRequest;
use App\Http\Requests\Statistic\KPIRequest;
use App\Models\User;
use App\Repositories\Admin\Car\CarRepository;
use App\Repositories\Admin\Order\OrderRepository;
use App\Repositories\Admin\ServiceName\ServiceNameRepository;
use App\Repositories\Admin\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CarStatisticController extends BaseController
{
    public function __construct(
        private CarRepository         $carRepository = new CarRepository(),
        private OrderRepository       $orderRepository = new OrderRepository(),
        private ServiceNameRepository $serviceNameRepository = new ServiceNameRepository(),
        private UserRepository        $userRepository = new UserRepository(),
    )
    {
        //
    }

    public function sumDefectiveActWorkForCar(CarStatisticRequest $request)
    {
        $roleId = Auth::user()->role_id;

        if ($roleId === 3) {
            $serviceName = $this->serviceNameRepository->getAll()->pluck('name');

            if (!empty($request->input())) {
                $data = CarStatisticData::from($request->validated());

                $carIds = $this->carRepository->carIds($data);

                $statistics = $this->orderRepository->sumDefectAct($carIds, $serviceName);

                return response()->json($statistics, 200, [], JSON_FORCE_OBJECT);
            } else {
                foreach ($serviceName as $value)
                    $service[] = ['name' => $value];
                return $service;
            }
        } else {
            return null;
        }
    }

    public function KPI(KPIRequest $request)
    {
        $roleId = Auth::user()->role_id;

        if ($roleId === 3) {
//            $startDate = Carbon::parse($request->input()['start'])->format('Y-m-d') . ' 00:00:00';
//            $endDate = Carbon::parse($request->input()['end'])->format('Y-m-d') . ' 23:59:59';
            $startDate = '2023-10-10 00:00:00';
            $endDate =   '2023-12-22 23:59:59';

            $managers = $this->userRepository->allManager();

            foreach ($managers as $index => $manager) {
                $order = $this->orderRepository->orderWithManeger($manager, $startDate, $endDate);
                $kpi[$index] = $order;
            }
            return $kpi;
        } else {
            return null;
        }
    }
}
