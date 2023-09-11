<?php

namespace App\Http\Controllers\Client\Car;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Car\CarRepository;
use App\Transformers\Api\Client\Car\CarIndexTransformer;

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
