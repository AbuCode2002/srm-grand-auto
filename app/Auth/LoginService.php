<?php

namespace App\Auth;

use Exception;
use App\Auth\Data\LoginData;
use App\Auth\Data\TokenData;
use Illuminate\Http\JsonResponse;
use App\Auth\Exceptions\LoginOrPasswordIncorrectException;
use App\Auth\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @param LoginData $data
     *
     * @return TokenData
     * @throws LoginOrPasswordIncorrectException
     */
    public function login(LoginData $data): TokenData
    {
        if(!Auth::validate($data->toArray())) {
            $this->throwLoginOrPasswordException();
        }

        return $this->userRepository->createJwt(Auth::user());
    }

    /**
     * @return void
     * @throws LoginOrPasswordIncorrectException
     * @throws Exception
     */
    private function throwLoginOrPasswordException(): void
    {
        throw new LoginOrPasswordIncorrectException(
            'Login or password incorrect',
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
