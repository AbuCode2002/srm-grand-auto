<?php

namespace App\Http\Controllers\Client\Driver;

use App\Http\Controllers\BaseController;
use App\Models\Driver;
use App\Repositories\Client\Driver\DriverRepository;
use App\Transformers\Api\Client\Driver\DriverIndexTransformer;
use Illuminate\Http\Client\Request;

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
