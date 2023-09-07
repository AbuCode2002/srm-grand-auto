<?php

namespace App\Http\Requests\Station;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StationRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'region_id'   => ['required', 'integer'],
        ];
    }
}
