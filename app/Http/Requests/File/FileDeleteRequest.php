<?php
namespace App\Http\Requests\File;

use App\Http\Requests\BaseRequest;

class FileDeleteRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'result' => ["string"],
        ];
    }
}
