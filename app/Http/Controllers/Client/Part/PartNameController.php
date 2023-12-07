<?php

namespace App\Http\Controllers\Client\Part;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Part\PartNameRepository;
use App\Repositories\Client\Role\RoleRepository;
use App\Repositories\Client\ServiceName\ServiceNameRepository;
use App\Transformers\Api\Client\Part\PartNameIndexTransformer;
use App\Transformers\Api\Client\Role\RoleIndexTransformer;
use App\Transformers\Api\Client\ServiceName\ServiceNameIndexTransformer;
use Illuminate\Http\JsonResponse;

class PartNameController extends BaseController
{

    /**
     * @param PartNameRepository $partNameRepository
     */
    public function __construct(
        private PartNameRepository $partNameRepository = new PartNameRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->partNameRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($roles, new PartNameIndexTransformer()),
                "created",
            );
    }
}
