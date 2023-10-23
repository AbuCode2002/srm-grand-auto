<?php

namespace App\Http\Controllers\Manager\File;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Manager\File\Data\FileData;
use App\Http\Requests\FileShow\FileShowRequest;
use App\Models\OrderFile;
use App\Transformers\Api\Manager\File\FileIndexTransformer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
    public function showPath(int $orderId)
    {
        $paths = OrderFile::query()->where('order_id', $orderId)->pluck('file_name');

        $url = [];
//        $url = Storage::disk('s3')->url("files/2/1697708537");
        foreach ($paths as $index => $path) {
            $url[$index] = Storage::disk('s3')->url($path);
        }

        preg_match('/([^\/]+)$/', $paths);
        return [
            "url" => $url,
            "name" => $paths
        ];
    }
//    public function showPath(int $orderId)
//    {
//        $files = OrderFile::query()->where('order_id', $orderId)->get();
//
//        return $this->respondWithSuccess(
//            $this->transformCollection($files, new FileIndexTransformer()),
//            'success',
//        );
//    }
}
