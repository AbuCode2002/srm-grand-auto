<?php

namespace App\Http\Controllers\Manager\Car;

use App\Http\Controllers\BaseController;
use App\Repositories\Manager\Car\CarRepository;
use App\Transformers\Api\Manager\Car\CarIndexTransformer;

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
