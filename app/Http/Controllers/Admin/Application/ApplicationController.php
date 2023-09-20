<?php

namespace App\Http\Controllers\Admin\Application;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Application\ApplicationRepository;
use App\Transformers\Api\Admin\Application\ApplicationIndexTransformer;
use Illuminate\Http\JsonResponse;

class ApplicationController extends BaseController
{
    /**
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(
        private ApplicationRepository $applicationRepository = new ApplicationRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $applications = $this->applicationRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($applications, new ApplicationIndexTransformer()),
                "created",
            );
    }
}
