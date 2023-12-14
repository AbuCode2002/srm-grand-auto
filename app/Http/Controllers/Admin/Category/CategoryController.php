<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\BaseController;
use App\Repositories\Admin\Category\CategoryRepository;
use App\Transformers\Api\Admin\Category\CategoryIndexTransformer;

class CategoryController extends BaseController
{
    public function __construct(
        private CategoryRepository $categoryRepository = new CategoryRepository(),
    )
    {
        //
    }

    public function index()
    {
        $category = $this->categoryRepository->getAll();

            return $this->respondWithSuccess(
                $this->transformCollection($category, new CategoryIndexTransformer()),
                "created",
            );
    }
}
