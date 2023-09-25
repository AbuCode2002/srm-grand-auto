<?php

namespace App\Http\Controllers\Station\Diagnostics;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Station\Diagnostics\Data\DiagnosticsData;
use App\Http\Requests\Diagnostics\DiagnosticsStoreRequest;
use App\Repositories\Station\Diagnostics\DiagnosticsRepository;
use App\Transformers\Api\Station\Diagnostics\DiagnosticsIndexTransformer;
use Illuminate\Http\JsonResponse;

class DiagnosticsController extends BaseController
{
    /**
     * @param DiagnosticsRepository $diagnosticsRepository
     */
    public function __construct(
        private DiagnosticsRepository $diagnosticsRepository = new DiagnosticsRepository(),
    )
    {
        //
    }

    public function store(int $orderId ,DiagnosticsStoreRequest $request): JsonResponse
    {
        $data = DiagnosticsData::from($request->validated());

        $diagnostics = $this->diagnosticsRepository->store($data, $orderId);

        return $this->respondWithSuccess(
            $this->transformItem($diagnostics, new DiagnosticsIndexTransformer),
            'created'
        );
    }
}
