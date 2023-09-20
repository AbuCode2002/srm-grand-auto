<?php

namespace App\Http\Controllers\Station\Client;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\Client\ClientRepository;
use App\Transformers\Api\Station\Client\ClientIndexTransformer;
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
