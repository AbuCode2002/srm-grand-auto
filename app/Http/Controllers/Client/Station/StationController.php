<?php

namespace App\Http\Controllers\Client\Station;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Client\Order\Data\OrderData;
use App\Http\Controllers\Client\Station\Data\StationData;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\Station\StationRequest;
use App\Repositories\Client\Order\OrderRepository;
use App\Repositories\Client\Station\StationRepository;
use App\Transformers\Api\Client\Order\OrderIndexTransformer;
use App\Transformers\Api\Client\Station\StationShowTransformer;
use Illuminate\Http\Request;

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

    public function show(StationRequest $request)
    {
        $data = StationData::from($request->validated());

        $station = $this->stationRepository->show($data);

        return $this->respondWithSuccess(
            $this->transformCollection($station, new StationShowTransformer()),
            "success",
        );;
    }
}
