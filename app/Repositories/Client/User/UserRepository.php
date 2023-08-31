<?php

namespace App\Repositories\Client\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
