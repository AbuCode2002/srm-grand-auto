<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class OrderEditRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return[
            "id"                  => ["integer"],
            "car_id"              => ["integer"],
            "region_id"           => ["integer"],
            "is_evacuated"        => ["bool"],
            "contract_id"         => ["integer"],
            "problem_description" => ["string"],
            "is_broken"           => ["bool"],
            "service_type"        => ["string"],
            "driver_id"           => ["integer"],
            "driver_type"         => ["string"],
            "station_id"          => ["integer"],
            "mileage"             => ["integer"],
            "status"              => ["integer"],
            "statusName"          => ["string"],
            "date"                => ["date"],
        ];
    }
}
