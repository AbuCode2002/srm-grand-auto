<?php

namespace App\Repositories\Manager\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = User::class;
    }

    public function show($userId)
    {
        return $this->model::query()->where('id' , $userId)->get();
    }
}
