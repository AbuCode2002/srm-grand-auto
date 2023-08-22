<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return[
            "car_id"              =>["required", "integer"],
            "client_id"           =>["required", "integer"],
            "region_id"           =>["required", "integer"],
            "is_evacuated"        =>["required", "bool"],
            "contract_id"         =>["required", "integer"],
            "problem_description" =>["required", "string"],
            "is_broken"           =>["required", "bool"],
            "service_type"        =>["required", "string"],
            "driver_id"           =>["required", "integer"],
            "driver_type"         =>["required", "string"],
            "mileage"             =>["required", "integer"],
        ];
    }
}
