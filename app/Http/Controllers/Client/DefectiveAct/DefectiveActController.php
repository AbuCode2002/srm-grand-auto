<?php

namespace App\Http\Controllers\Client\DefectiveAct;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DefectiveAct\DefectiveActRequest;
use App\Repositories\Client\Contract\ContractRepository;
use App\Repositories\Client\DefectiveAct\DefectiveActRepository;
use App\Transformers\Api\Client\Contract\ContractIndexTransformer;
use App\Transformers\Api\Client\DefectiveAct\DefectiveActIndexTransformer;
use Illuminate\Http\JsonResponse;

class DefectiveActController extends BaseController
{
    /**
     * @param DefectiveActRepository $defectiveActRepository
     */
    public function __construct(
        private DefectiveActRepository $defectiveActRepository = new DefectiveActRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function store(DefectiveActRequest $defectiveActRequest)
    {
        $defectiveAct = $this->defectiveActRepository->store();

            return $this->respondWithSuccess(
                $this->transformCollection($defectiveAct, new DefectiveActIndexTransformer()),
                "created",
            );
    }
}
