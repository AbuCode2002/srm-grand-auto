<?php

namespace App\Http\Controllers\Station\Car;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\Car\CarRepository;
use App\Transformers\Api\Station\Car\CarIndexTransformer;

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
        $contracts = $this->carRepository->index();

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
}
