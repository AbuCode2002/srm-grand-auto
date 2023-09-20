<?php

namespace App\Http\Controllers\Station\Driver;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\Driver\DriverRepository;
use App\Transformers\Api\Station\Driver\DriverIndexTransformer;

class DriverController extends BaseController
{
    public function __construct(
        private DriverRepository $driverRepository = new DriverRepository(),
    )
    {
        //
    }

    public function index()
    {
        $contracts = $this->driverRepository->showName();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new DriverIndexTransformer()),
                "created",
            );
    }
}
