<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'password'   => ['required', 'confirmed', 'min:6'],
            'email'      => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->whereNull('deleted_at'),
            ],
            'name'   => ['string'],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }
}
