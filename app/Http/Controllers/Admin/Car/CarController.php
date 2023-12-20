<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Car\CarRepository;
use App\Transformers\Api\Admin\Car\CarIndexTransformer;
use Illuminate\Support\Facades\Auth;

class CarController extends BaseController
{
    public function __construct(
        private CarRepository $carRepository = new CarRepository(),
    )
    {
        //
    }

    public function index()
    {
        $contracts = $this->carRepository->idNumber();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new CarIndexTransformer()),
                "created",
            );
    }

    public function show(int $id)
    {
        $contracts = $this->carRepository->show($id);

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new CarIndexTransformer()),
                "created",
            );
    }

    public function carName()
    {
        return $this->carRepository->carName();
    }

    public function statistic()
    {
        $roleId = Auth::user()->role_id;

        if ($roleId === 3) {
            $service = $this->carRepository->serviceStatistic();

            $part = $this->carRepository->partStatistic();

            $category = $this->carRepository->categoryStatistic();

            $car['service'] = $service;

            $car['part'] = $part;

            $car['category'] = $category;

            return $car;
        }else {
            return null;
        }
    }
}
