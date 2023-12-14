<?php

namespace App\Repositories\Admin\Category;

use App\Http\Controllers\Admin\CarStatistic\Data\CarStatisticData;
use App\Models\Car;
use App\Models\PartCategory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\s;

class CategoryRepository extends BaseRepository
{
    /**
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = PartCategory::class;
    }
}
