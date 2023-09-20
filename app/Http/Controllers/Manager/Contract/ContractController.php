<?php

namespace App\Http\Controllers\Manager\Contract;

use App\Http\Controllers\BaseController;
use App\Repositories\Manager\Contract\ContractRepository;
use App\Transformers\Api\Manager\Contract\ContractIndexTransformer;
use Illuminate\Http\JsonResponse;

class ContractController extends BaseController
{
    /**
     * @param ContractRepository $contractRepository
     */
    public function __construct(
        private ContractRepository $contractRepository = new ContractRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $contracts = $this->contractRepository->contractByUser();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new ContractIndexTransformer()),
                "created",
            );
    }
}
