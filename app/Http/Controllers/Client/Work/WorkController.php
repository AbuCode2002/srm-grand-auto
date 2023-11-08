<?php

namespace App\Http\Controllers\Client\Work;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Work\WorkRepository;
use App\Transformers\Api\Client\Work\WorkIndexTransformer;

class WorkController extends BaseController
{
    public function __construct(
        private WorkRepository $workRepository = new WorkRepository(),
    )
    {
        //
    }

    public function index()
    {
        $contracts = $this->workRepository->index();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new WorkIndexTransformer()),
                "created",
            );
    }
}
