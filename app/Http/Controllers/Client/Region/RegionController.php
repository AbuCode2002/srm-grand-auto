<?php

namespace App\Http\Controllers\Client\Region;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Contract\ContractRepository;
use App\Repositories\Client\Region\RegionRepository;
use App\Transformers\Api\Client\Application\ApplicationIndexTransformer;
use App\Transformers\Api\Client\Contract\ContractIndexTransformer;
use App\Transformers\Api\Client\Region\RegionIndexTransformer;

class RegionController extends BaseController
{
    public function __construct(
        private RegionRepository $regionRepository = new RegionRepository(),
    )
    {
        //
    }

    public function index()
    {
        $contracts = $this->regionRepository->regionByUser();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new RegionIndexTransformer()),
                "created",
            );
    }

    public function show(int $id)
    {
        $contracts = $this->regionRepository->show($id);

        return $this->respondWithSuccess(
            $this->transformCollection($contracts, new RegionIndexTransformer()),
            "created",
        );
    }
}
