<?php

namespace App\Http\Controllers\Admin\Statistic;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Car\CarRepository;
use App\Repositories\Admin\Work\WorkRepository;

class StatisticController extends BaseController
{
    public function __construct(
        private CarRepository $carRepository = new CarRepository(),
        private WorkRepository $workRepository = new WorkRepository(),
    )
    {
        //
    }

    public function index()
    {
        $cars = $this->carRepository->index();

        $works = $this->workRepository->index();

            return [
                "car" => $cars->brand . " " . $cars->model,
                "parts" => $works->name
            ];
    }


}
