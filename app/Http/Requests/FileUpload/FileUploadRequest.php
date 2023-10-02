<?php
namespace App\Http\Requests\FileUpload;

use App\Http\Requests\BaseRequest;

class FileUploadRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'video' => ["required","mimetypes:video/*"],
        ];
    }
}
