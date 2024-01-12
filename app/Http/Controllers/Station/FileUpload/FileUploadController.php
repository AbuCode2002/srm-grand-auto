<?php

namespace App\Http\Controllers\Station\FileUpload;

use App\Http\Controllers\BaseController;
use App\Http\Requests\File\FileUploadRequest;
use App\Models\OrderFile;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class FileUploadController extends BaseController
{
    public function upload(FileUploadRequest $request, int $orderId)
    {
        $videoPath = '';
        foreach ($request->file('file') as $value) {
            preg_match('/^([^\/]+)/', $value->getMimeType(), $format);
            $time = time();

            if ($format[1] == 'video') {

                $ffmpeg = FFMpeg\FFMpeg::create();
                $video = $ffmpeg->open($value->path());

                $videoDimensions = $video->getStreams()->videos()->first()->getDimensions();

                $video
                    ->filters()
                    ->resize(new FFMpeg\Coordinate\Dimension($videoDimensions->getWidth(), $videoDimensions->getHeight()))
                    ->synchronize();

                $format = new X264();
                $format->setKiloBitrate(500);

                $tempPath = public_path("{$time}" . '.mp4');

                $video->save($format, $tempPath);

                Storage::disk('s3')->put("files/{$orderId}/{$time}", file_get_contents($tempPath));

                unlink($tempPath);

                $videoPath = "files/{$orderId}/" . $time;

            } elseif ($format[1] == 'image') {

                $tempFilePath = $value->getRealPath();

                $compressedImage = Image::make($tempFilePath)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 80);

                $videoPath = "files/{$orderId}/" . $time;

                Storage::disk('s3')->put($videoPath, $compressedImage);

            } elseif ($format[1] == 'application') {

                $videoPath = "files/{$orderId}/" . $time;

                $value->storeAs($videoPath, $time . '.pdf', 's3');

            }
            $orderFile = new OrderFile();

            $orderFile->order_id = $orderId;

            $orderFile->file_name = $videoPath . '/' . $time . '.pdf';

            $orderFile->save();
        }

        return response()->json(['video_path' => $videoPath]);
    }
}
