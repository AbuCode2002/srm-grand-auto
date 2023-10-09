<?php
namespace App\Http\Requests\FileShow;

use App\Http\Requests\BaseRequest;

class FileShowRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'path' => ["required", "string"],
        ];
    }
}
