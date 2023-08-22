<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Data\LoginData;
use App\Auth\Data\RegisterData;
use App\Auth\Exceptions\LoginOrPasswordIncorrectException;
use App\Auth\ForgotPasswordChangeService;
use App\Auth\ForgotPasswordCreateService;
use App\Auth\LoginService;
use App\Auth\RegisterService;
use App\Auth\SocialService;
use App\Auth\VerifyEmailAccountService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Transformers\Api\Auth\TokenDataTransformer;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    /**
     * @var LoginService
     */
    private LoginService $loginService;

    private RegisterService $registerService;


    public function __construct()
    {
        $this->loginService    = new LoginService();
        $this->registerService = new RegisterService();
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     * @throws LoginOrPasswordIncorrectException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = LoginData::from($request->validated());

        $tokenData = $this->loginService->login($data);

        return $this->respondWithSuccess(
            $this->transformItem($tokenData, new TokenDataTransformer()),
            "success"
        );
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = RegisterData::from($request->validated());

        $tokenData = $this->registerService->register($data);

        return $this->respondWithSuccess(
            $this->transformItem($tokenData, new TokenDataTransformer()),
            "success"
        );
    }
}
