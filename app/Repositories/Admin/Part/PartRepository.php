<?php

namespace App\Repositories\Admin\Part;

use App\Models\Part;
use App\Models\Region;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PartRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = Part::class;
    }

    public function index(): Collection|array
    {
        return $this->model::query()->get();
    }
}
