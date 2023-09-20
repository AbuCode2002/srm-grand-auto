<?php

namespace App\Http\Controllers\Manager\User;

use App\Http\Controllers\BaseController;
use App\Repositories\Manager\User\UserRepository;
use App\Transformers\Api\Manager\User\UserIndexTransformer;
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
                $this->transformCollection($user, new UserIndexTransformer()),
                "created",
            );
    }
}
