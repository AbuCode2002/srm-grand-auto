<?php

namespace App\Auth;

use App\Auth\Data\RegisterData;
use App\Auth\Data\TokenData;
use App\Auth\Jobs\SendEmailVerificationCode;
use App\Auth\Repositories\SocialAccountRepository;
use App\Auth\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegisterService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var SocialAccountRepository
     */
    private SocialAccountRepository $socialAccountRepository;

    public function __construct()
    {
        $this->userRepository          = new UserRepository();
        $this->socialAccountRepository = new SocialAccountRepository();
    }

    /**
     * @param RegisterData $data
     *
     * @return TokenData
     * @throws Throwable
     */
    public function register(RegisterData $data): TokenData
    {
        $tokenData = null;

        try {
            DB::beginTransaction();

            $user      = $this->userRepository->create($data);

            $tokenData = $user->jwt();

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }

        return $tokenData;
    }
}
