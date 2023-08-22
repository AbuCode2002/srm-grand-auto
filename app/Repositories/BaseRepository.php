<?php

namespace App\Repositories;

use Exception;
use App\Exceptions\DatabaseException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
abstract class BaseRepository
{
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @var string|Model
     */
    protected string|Model $model;

    /**
     * Cache time
     *
     * @var int
     */
    protected int $cacheTime;

    /**
     * Pagination step
     *
     * @var int
     */
    protected int $perPage = 10;

    /**
     * @return int
     */
    public function getCacheTime() : int
    {
        return $this->cacheTime;
    }

    /**
     * @param int $cacheTime
     */
    public function setCacheTime(
        int $cacheTime,
    ) : void
    {
        $this->cacheTime = $cacheTime;
    }

    /**
     * @return int
     */
    public function getPerPage() : int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(
        int $perPage,
    ) : void
    {
        $this->perPage = $perPage;
    }

    /**
     * @param int $id
     *
     * @return Model|Collection
     */
    public function findById(
        int $id,
    ) : Collection|Model
    {
        return $this->model::query()->findOrFail($id);
    }

    /**
     * @param int $id
     *
     * @return Model|Collection
     */
    public function findByIdWithGameAndFormats(
        int $id,
    ) : Collection|Model
    {
        return $this->model::query()
            ->with(['formats', 'game', 'country'])
            ->findOrFail($id);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(
        array $data,
    ) : bool
    {
        return $this->model::query()->insert($data);
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAll($limit = null) : Collection|array
    {
        $model = $this->model::query();

        if ($limit) {
            $model->limit($limit);
        }

        return $model->get();
    }


    /**
     * @return void
     */
    abstract protected function setModel() : void;

    /**
     * @param Model $model
     *
     * @return bool|null
     */
    public function delete(
        Model $model,
    ) : ?bool
    {
        return $model->delete();
    }

    /**
     * @return Model|Builder
     */
    public function getRandomRecord() : Model|Builder
    {
        return $this->model::query()
            ->inRandomOrder()
            ->firstOrFail();
    }
}
