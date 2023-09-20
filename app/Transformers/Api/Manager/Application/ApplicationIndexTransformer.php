<?php

namespace App\Transformers\Api\Manager\Application;

use App\Models\Application;
use App\Transformers\BaseTransformer;

class ApplicationIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'application';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'applications';
    }

    /**
     * @param Application $application
     * @return array
     */
    public function transform(Application $application): array
    {
        return [
            "type" => $application->type,
        ];
    }
}
