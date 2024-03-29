<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\User\UserRepository;
use App\Transformers\Api\Admin\User\UserShowTransformer;
use App\Transformers\Api\Admin\User\UserIndexTransformer;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function __construct(
        private UserRepository $userRepository = new UserRepository(),
    )
    {
        //
    }

    public function show()
    {
        $user = $this->userRepository->show(Auth::id());

            return $this->respondWithSuccess(
                $this->transformCollection($user, new UserShowTransformer()),
                "created",
            );
    }

    public function allManager()
    {
        $users = $this->userRepository->allManager();

            return $this->respondWithSuccess(
                $this->transformCollection($users, new UserIndexTransformer()),
                "created",
            );
    }
}
