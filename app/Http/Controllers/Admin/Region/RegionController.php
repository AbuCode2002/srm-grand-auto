<?php

namespace App\Http\Controllers\Admin\Region;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Contract\ContractRepository;
use App\Repositories\Admin\Order\OrderRepository;
use App\Repositories\Admin\Region\RegionRepository;
use App\Transformers\Api\Admin\Region\ParentRegionIndexTransformer;
use App\Transformers\Api\Admin\Region\RegionIndexTransformer;

class RegionController extends BaseController
{
    public function __construct(
        private RegionRepository $regionRepository = new RegionRepository(),
        private OrderRepository $orderRepository = new OrderRepository(),
        private ContractRepository $contractRepository = new ContractRepository(),
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

    public function indexParentRegion()
    {
        $contractId = 1; //TODO: contractId должен передавать фронт

        $markup = 1 + ($this->contractRepository->companyByContractId($contractId)->company->markup) / 100;

        $regions = $this->regionRepository->region();

        $this->orderRepository->sumUsed($regions);

        $this->orderRepository->sumWork($regions, $markup);

        return $this->respondWithSuccess(
            $this->transformCollection($regions, new ParentRegionIndexTransformer()),
            "created",
        );
    }
}
