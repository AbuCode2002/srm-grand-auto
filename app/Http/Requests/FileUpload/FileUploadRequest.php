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
//        dd($this->request);
        return [
//            'file' => ["required","mimetypes:video/*"],
//            'file' => ["required", "array", "mimetypes:video/*,image/*"],
            'file' => ["required", "array"],
        ];
    }
}
