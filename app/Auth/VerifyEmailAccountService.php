<?php

namespace App\Auth;

use App\Auth\Data\TokenData;
use App\Auth\Data\VerifyEmailAccountData;
use App\Auth\Exceptions\SocialAccountNotExistsException;
use App\Auth\Exceptions\VerificationCodeExpiredException;
use App\Auth\Exceptions\VerificationCodeInvalidException;
use App\Auth\Repositories\SocialAccountRepository;
use App\Auth\Repositories\UserRepository;
use App\Models\Mysql\SocialAccount;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Throwable;

class VerifyEmailAccountService
{
    /**
     * @var SocialAccountRepository
     */
    private SocialAccountRepository $socialAccountRepositry;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->socialAccountRepositry = new SocialAccountRepository();
        $this->userRepository         = new UserRepository();
    }

    /**
     * @param User|Authenticatable   $user
     * @param VerifyEmailAccountData $data
     *
     * @return void
     * @throws SocialAccountNotExistsException
     * @throws Throwable
     * @throws VerificationCodeExpiredException
     * @throws VerificationCodeInvalidException
     */
    public function verify(User|Authenticatable $user, VerifyEmailAccountData $data): void
    {
        $socialAccount = $this->socialAccountRepositry->emailProviderByEmail($user->email);

        if (is_null($socialAccount)) {
            throw new SocialAccountNotExistsException('No such user exists');
        }

        $this->isCodeExpired($socialAccount);

        $this->isCodeInvalid($socialAccount, $data->code);

        try {
            DB::beginTransaction();

            $socialAccount = $this->socialAccountRepositry->verify($socialAccount);

            //$this->socialAccountRepositry->makePrimary($socialAccount);

            //$this->userRepository->setPrimaryEmail($socialAccount->user);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param SocialAccount $socialAccount
     *
     * @return void
     * @throws VerificationCodeExpiredException
     */
    public function isCodeExpired(SocialAccount $socialAccount): void
    {
        if ($socialAccount->code_created_at && $socialAccount->code_created_at->lt(now()->subMinutes(5))) { #@todo вынесты в конфиг
            throw new VerificationCodeExpiredException('Given code expired');
        }
    }

    /**
     * @param SocialAccount $socialAccount
     * @param string        $code
     *
     * @return void
     * @throws VerificationCodeInvalidException
     */
    private function isCodeInvalid(SocialAccount $socialAccount, string $code): void
    {
        if ($socialAccount->code && $socialAccount->code !== $code) {
            throw new VerificationCodeInvalidException('Given code invalid');
        }
    }
}