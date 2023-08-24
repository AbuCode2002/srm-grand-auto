<?php

namespace App\Http\Controllers\Auth;

use App\Auth\Data\LoginData;
use App\Auth\Data\RegisterData;
use App\Auth\Exceptions\LoginOrPasswordIncorrectException;
use App\Auth\LoginService;
use App\Auth\RegisterService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Transformers\Api\Auth\TokenDataTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends BaseController
{
//    /**
//     * @var LoginService
//     */
//    private LoginService $loginService;

    /**
     * @var RegisterService
     */
    private RegisterService $registerService;


    public function __construct()
    {
//        $this->loginService    = new LoginService();
        $this->registerService = new RegisterService();
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'register']]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! $token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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


    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * @return mixed
     */
    public function refresh(): mixed
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
