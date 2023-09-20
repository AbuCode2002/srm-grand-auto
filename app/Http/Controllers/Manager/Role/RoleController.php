<?php

namespace App\Http\Controllers\Manager\Role;

use App\Http\Controllers\BaseController;
use App\Repositories\Manager\Role\RoleRepository;
use App\Transformers\Api\Manager\Role\RoleIndexTransformer;
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
