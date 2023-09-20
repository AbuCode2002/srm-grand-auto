<?php

namespace App\Http\Controllers\Manager\Region;

use App\Http\Controllers\BaseController;
use App\Repositories\Manager\Region\RegionRepository;
use App\Transformers\Api\Manager\Region\RegionIndexTransformer;

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
