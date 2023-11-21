<?php

namespace App\Http\Controllers\Manager\File;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Manager\File\Data\FileDeleteData;
use App\Http\Requests\File\FileDeleteRequest;
use App\Models\Order;
use App\Models\OrderFile;
use App\Repositories\Manager\File\FileRepository;
use DateTime;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
    public function __construct(
        private FileRepository $fileRepository = new FileRepository(),
    )
    {
        //
    }
    public function showPath(int $orderId)
    {
        $paths = OrderFile::query()->where('order_id', $orderId)->pluck('file_name');

        $url = [];
        foreach ($paths as $index => $path) {
            $url[$index] = Storage::disk('s3')->url($path);
        }

        preg_match('/([^\/]+)$/', $paths);
        return [
            "url" => $url,
            "name" => $paths
        ];
    }

    public function delete(int $orderId, FileDeleteRequest $request): void
    {
        $data = FileDeleteData::from($request->validated());

        $this->fileRepository->acceptOrRejectFile($orderId ,$data);
    }
}
