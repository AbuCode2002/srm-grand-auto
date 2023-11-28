<?php

namespace App\Repositories\Client\Contract;

use App\Models\Contract;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ContractRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Contract::class;
    }

    public function contractByUser(): Collection|array
    {
        $userId = Auth::user()->id;

            return $this->model::query()
            ->withWhereHas('userCompany', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->get();
    }

    public function indexAll(): Collection|array
    {
            return $this->model::query()->get();
    }
}
