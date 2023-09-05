<?php

namespace App\Traits\Response;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use stdClass;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ApiResponseTrait
 *
 * @package App\Traits\Response
 */
trait ApiResponseTrait
{
    /** @var int */
    private int $statusCode = Response::HTTP_OK;

    /** @var array|null */
    private ?array $pagination = null;

    /**
     * @param LengthAwarePaginator $paginator
     * @return ApiResponseTrait|BaseController
     */
    protected function setPagination(LengthAwarePaginator $paginator): self
    {
        $this->pagination = [
            'page'  => $paginator->currentPage(),
            'by'    => $paginator->perPage(),
            'total' => $paginator->total(), //$paginator->lastPage() * $paginator->perPage()
            'links' => $paginator->options(),
        ];

        return $this;
    }

    /**
     * @param array|null $data
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function respondWithSuccess(
        array  $data = null,
        string $message = null
    ): JsonResponse
    {
        $responseBody = $data !== null ? $data : [];
        if ($message !== null) {
            $responseBody['message'] = $message;
        }
        if ($this->pagination !== null) {
            $responseBody['pagination'] = $this->pagination;
            $this->pagination = null;
        }
        if (empty($responseBody)) {
            $responseBody = new stdClass;
        }
        return $this->respond($responseBody);
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    private function respond($data = [], $headers = []): JsonResponse
    {
        return response()->json(
            $data,
            $this->getStatusCode(),
            $headers,
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * @return int
     */
    protected function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    protected function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function respondWithError(string $message = null): JsonResponse
    {
        return $this->respondRawError($message);
    }

    /**
     * @param $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    private function respondRawError($data, int $statusCode = 400): JsonResponse
    {
        if (is_string($data)) {
            $responseBody = [
                'errors' => []
            ];

            if ($data !== null) {
                $responseBody['errors']['message'] = $data;
            }

            if (empty($responseBody['errors'])) {
                $responseBody['errors'] = new stdClass;
            }
        } elseif (is_array($data)) {
            $responseBody = [
                'errors' => $data
            ];
        } else {
            $responseBody = [
                'errors' => [
                    'message' => 'Unknown error.'
                ]
            ];
        }

        return $this->setStatusCode($statusCode)
            ->respond($responseBody);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNotFound(string $message = null): JsonResponse
    {
        return $this->respondRawError($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param array $messages
     *
     * @return JsonResponse
     */
    protected function respondWithValidationError(array $messages): JsonResponse
    {
        return $this->respondRawError($messages, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param string|null $message
     *
     * @return JsonResponse
     */
    protected function respondWithAuthorizationError(string $message = null): JsonResponse
    {
        $message = ($message === null ? 'Authorization error.' : $message);

        return $this->respondRawError($message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param string $filePath
     *
     * @return BinaryFileResponse
     */
    protected function respondWithDownload(string $filePath): BinaryFileResponse
    {
        return response()->download(
            storage_path('app/private/' . $filePath)
        );
    }
}
