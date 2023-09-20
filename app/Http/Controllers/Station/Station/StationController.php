<?php

namespace App\Http\Controllers\Station\Station;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\Station\StationRepository;
use App\Transformers\Api\Station\Station\StationShowTransformer;
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
