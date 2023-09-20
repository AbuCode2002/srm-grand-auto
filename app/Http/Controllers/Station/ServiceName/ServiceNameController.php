<?php

namespace App\Http\Controllers\Station\ServiceName;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\ServiceName\ServiceNameRepository;
use App\Transformers\Api\Station\ServiceName\ServiceNameIndexTransformer;
use Illuminate\Http\JsonResponse;

class ServiceNameController extends BaseController
{

    /**
     * @param ServiceNameRepository $serviceNameRepository
     */
    public function __construct(
        private ServiceNameRepository $serviceNameRepository = new ServiceNameRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->serviceNameRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($roles, new ServiceNameIndexTransformer()),
                "created",
            );
    }
}
