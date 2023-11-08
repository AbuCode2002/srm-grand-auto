<?php

namespace App\Http\Controllers\Manager\File;

use App\Http\Controllers\BaseController;
use App\Models\OrderFile;
use Illuminate\Support\Facades\Storage;

class FileController extends BaseController
{
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
}
