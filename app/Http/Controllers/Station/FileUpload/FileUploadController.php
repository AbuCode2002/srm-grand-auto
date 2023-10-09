<?php

namespace App\Http\Controllers\Station\FileUpload;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FileUpload\FileUploadRequest;
use App\Models\OrderFile;

class FileUploadController extends BaseController
{
    public function upload(FileUploadRequest $request, int $orderId)
    {
        foreach ($request->file('file') as $value) {

            $videoPath = $value->store("videos/{$orderId}", 'public');

            $orderFile = new OrderFile();

            $orderFile->order_id = $orderId;

            $orderFile->file_name = $videoPath;

            $orderFile->save();
        }

        return response()->json(['video_path' => $videoPath]);
    }
}
