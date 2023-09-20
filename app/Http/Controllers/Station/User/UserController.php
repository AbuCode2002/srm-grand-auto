<?php

namespace App\Http\Controllers\Station\User;

use App\Http\Controllers\BaseController;
use App\Repositories\Station\User\UserRepository;
use App\Transformers\Api\Station\User\UserIndexTransformer;
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
