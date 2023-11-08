<?php
namespace App\Http\Requests\CarStatistic;

use App\Http\Requests\BaseRequest;

class CarStatisticRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "carName" => ["array"],
        ];
    }
}
