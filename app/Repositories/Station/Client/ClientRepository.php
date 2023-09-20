<?php

namespace App\Repositories\Station\Client;

use App\Models\Client;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ClientRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Client::class;
    }

    public function index(): Collection|array
    {
        $userId = Auth::user()->id;

        return $this->model::query()->where('user_id', $userId)->get();
    }
}
