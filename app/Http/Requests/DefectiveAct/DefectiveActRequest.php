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
            "total" => ["integer"],
            "total_procent" => ["integer"],
            "service" => ["array"],
            "spare_parts" => ["array"],
        ];
    }
}
