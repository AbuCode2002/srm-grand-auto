<?php

namespace App\Http\Controllers\Station\FileUpload;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class FileUploadController extends BaseController
{
    public function upload(Request $request)
    {
        $request->validate([
            'video' => 'required|mimetypes:video/*',
        ]);

        $videoPath = $request->file('video')->store('videos', 'public');

        return response()->json(['video_path' => $videoPath]);
    }
}
