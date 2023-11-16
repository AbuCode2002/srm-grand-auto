<?php
namespace App\Http\Requests\Statistic;

use App\Http\Requests\BaseRequest;

class KPIRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "date" => ["string"],
        ];
    }
}
