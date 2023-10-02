<?php

namespace App\Http\Controllers\Station\FileUpload;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FileUpload\FileUploadRequest;

class FileUploadController extends BaseController
{
    public function upload(FileUploadRequest $request)
    {
        $videoPath = $request->file('video')->store('videos', 'public');

        return response()->json(['video_path' => $videoPath]);
    }
}
