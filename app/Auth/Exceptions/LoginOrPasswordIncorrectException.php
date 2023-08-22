<?php

namespace App\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class LoginOrPasswordIncorrectException extends Exception
{

    /**
     * @return JsonResponse
     */
    public function render() : JsonResponse
    {
        return response()->json(
            [
                'message' => 'Неверный логин или пароль'
            ],
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
        );
    }
}