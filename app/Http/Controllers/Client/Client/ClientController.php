<?php

namespace App\Http\Controllers\Client\Client;

use App\Http\Controllers\BaseController;
use App\Repositories\Client\Client\ClientRepository;
use App\Repositories\Client\Contract\ContractRepository;
use App\Transformers\Api\Client\Client\ClientIndexTransformer;
use App\Transformers\Api\Client\Contract\ContractIndexTransformer;
use Illuminate\Http\JsonResponse;

class ClientController extends BaseController
{
    public function __construct(
        private ClientRepository $clientRepository = new ClientRepository(),
    )
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $client = $this->clientRepository->index();

            return $this->respondWithSuccess(
                $this->transformCollection($client, new ClientIndexTransformer()),
                "created",
            );
    }
}
