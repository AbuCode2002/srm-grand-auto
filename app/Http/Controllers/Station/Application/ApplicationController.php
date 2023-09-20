<?php

namespace App\Http\Controllers\Station\Application;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\Application\ApplicationRepository;
use App\Transformers\Api\Station\Application\ApplicationIndexTransformer;
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
