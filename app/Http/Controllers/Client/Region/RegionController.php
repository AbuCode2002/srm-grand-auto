<?php

namespace App\Http\Controllers\Client\Contract;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Contract\ContractRepository;
use App\Transformers\Api\Client\Application\ApplicationIndexTransformer;
use App\Transformers\Api\Client\Contract\ContractIndexTransformer;

class ContractController extends BaseController
{
    public function __construct(
        private ContractRepository $contractRepository = new ContractRepository(),
    )
    {
        //
    }

    public function index()
    {
        $contracts = $this->contractRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($contracts, new ContractIndexTransformer()),
                "created",
            );
    }
}
