<?php

namespace App\Http\Requests\Diagnostics;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class DiagnosticsStoreRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return[
            "date"     =>["date"],
            "order_id" =>["string"],
        ];
    }
}
