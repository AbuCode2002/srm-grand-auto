<?php

namespace App\Http\Controllers\Client\ServiceName;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Role\RoleRepository;
use App\Repositories\Client\ServiceName\ServiceNameRepository;
use App\Transformers\Api\Client\Role\RoleIndexTransformer;
use App\Transformers\Api\Client\ServiceName\ServiceNameIndexTransformer;
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
