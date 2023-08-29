<?php

namespace App\Http\Controllers\Client\Driver;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Contract\ContractRepository;
use App\Repositories\Client\Driver\DriverRepository;
use App\Repositories\Client\Region\RegionRepository;
use App\Transformers\Api\Client\Application\ApplicationIndexTransformer;
use App\Transformers\Api\Client\Contract\ContractIndexTransformer;
use App\Transformers\Api\Client\Driver\DriverIndexTransformer;
use App\Transformers\Api\Client\Region\RegionIndexTransformer;

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
        $contracts = $this->driverRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new DriverIndexTransformer()),
                "created",
            );
    }
}
