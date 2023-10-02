<?php

namespace App\Http\Controllers\Client\Station;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Station\StationRepository;
use App\Transformers\Api\Client\Station\StationShowTransformer;
use Illuminate\Http\JsonResponse;

class StationController extends BaseController
{
    /**
     * @param StationRepository $stationRepository
     */
    public function __construct(
        private StationRepository $stationRepository = new StationRepository(),
    )
    {
        //
    }

    /**
     * @param int $regionId
     * @return JsonResponse
     */
    public function show(int $regionId, int $orderId): JsonResponse
    {
        $station = $this->stationRepository->show($regionId);

        return $this->respondWithSuccess(
            $this->transformCollection($station, new StationShowTransformer()),
            "success",
        );
    }
}
