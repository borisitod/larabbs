<?php

namespace App\Http\Requests\Api;

class VerificationCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|phone:AU,mobile|unique:users',
        ];
    }
}
