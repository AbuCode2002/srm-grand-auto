<?php

namespace App\Auth;

use App\Auth\Jobs\SendForgotPasswordJob;
use App\Auth\Repositories\ForgotPasswordRepository;
use App\Auth\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ForgotPasswordCreateService
{
    public function __construct(
        private UserRepository           $userRepository = new UserRepository(),
        private ForgotPasswordRepository $forgotPasswordRepository = new ForgotPasswordRepository(),
    )
    {
        //
    }

    /**
     * @param mixed $email
     *
     * @return void
     */
    public function forget(string $email): void
    {
        $user = $this->userRepository->byEmail($email);

        if (is_null($user)) {
            throw new ModelNotFoundException('Wrong email');
        }

        $forgotPassword = $this->forgotPasswordRepository->byUserIdAndLast($user->id);

        if(is_null($forgotPassword)) {
            $forgotPassword = $this->forgotPasswordRepository->createForUser($user);
        }

        #dispatch sending event
        dispatch(new SendForgotPasswordJob($forgotPassword->hash));
    }
}