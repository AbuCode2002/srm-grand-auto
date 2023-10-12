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
//    public function showFile(FileShowRequest $request, int $orderId)
//    {
//        $data = FileData::from($request->validated());
//
//        return response()
//            ->file(
//                storage_path(
//                    "app/public/{$data->path}"
//                )
//            );
//    }

    public function showPath(int $orderId)
    {
        $files = OrderFile::query()->where('order_id', $orderId)->get();

        return $this->respondWithSuccess(
            $this->transformCollection($files, new FileIndexTransformer()),
            'success',
        );
    }
}
