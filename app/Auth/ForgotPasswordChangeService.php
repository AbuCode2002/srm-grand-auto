<?php

namespace App\Auth;

use App\Auth\Repositories\ForgotPasswordRepository;
use App\Auth\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class ForgotPasswordChangeService
{

    public function __construct(
        private ForgotPasswordRepository $forgotPasswordRepository = new ForgotPasswordRepository(),
        private UserRepository           $userRepository = new UserRepository(),
    )
    {
        //
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws Throwable
     */
    public function change(array $data): void
    {
        $forgotPassword = $this->forgotPasswordRepository->byHashAndLastWithUser($data['hash']);

        if (is_null($forgotPassword)) {
            throw new Exception('Invalid hash');
        }

        try {
            DB::beginTransaction();

            $forgotPassword = $this->forgotPasswordRepository->setPassword($forgotPassword, $data['password']);

            $this->userRepository->setPassword($forgotPassword->user, $data['password']);

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}