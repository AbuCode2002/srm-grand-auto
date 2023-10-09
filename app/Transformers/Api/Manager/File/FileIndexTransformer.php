<?php

namespace App\Transformers\Api\Manager\File;

use App\Models\OrderFile;
use App\Transformers\BaseTransformer;

class FileIndexTransformer extends BaseTransformer
{

//    protected array $defaultIncludes = [];

    /**
     * @return string
     */
    public function getItemKey(): string
    {
        return 'file';
    }

    /**
     * @return string
     */
    public function getCollectionKey(): string
    {
        return 'files';
    }

    /**
     * @param OrderFile $file
     * @return array
     */
    public function transform(OrderFile $file): array
    {
        return [
            "file_name" => $file->file_name,
        ];
    }
}
