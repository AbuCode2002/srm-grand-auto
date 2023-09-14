<?php
namespace App\Http\Requests\DefectiveAct;

use App\Http\Requests\BaseRequest;

class DefectiveActRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "id" => ["integer"],
            "order_id" => ["integer"],
            "total" => ["integer"],
            "markup" => ["integer"],
            "total_with_markup" => ["integer"],
            "sum_sale" => ["string"],
        ];
    }
}
