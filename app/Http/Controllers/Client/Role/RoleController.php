<?php

namespace App\Http\Controllers\Client\Role;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Role\RoleRepository;
use App\Transformers\Api\Client\Role\RoleIndexTransformer;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseController
{

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        private RoleRepository $roleRepository = new RoleRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->roleRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($roles, new RoleIndexTransformer()),
                "created",
            );
    }
}
