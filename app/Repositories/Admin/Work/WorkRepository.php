<?php

namespace App\Repositories\Admin\Work;

use App\Models\Part;
use App\Models\Region;
use App\Models\Work;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class WorkRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Work::class;
    }

    public function index(): Collection|array
    {
        return $this->model::query()->get();
    }
}
