<?php
namespace App\Http\Requests\File;

use App\Http\Requests\BaseRequest;

class FileUploadRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => ["required"],
        ];
    }
}
