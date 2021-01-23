<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[a-zA-Z]+(([\',. -][a-zA-Z ])?[a-zA-Z]*)*$/|unique:users,name',
            'password' => 'required|alpha_dash|min:6',
            'verification_key' => 'required|string',
            'verification_code' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'verification_key' => 'SMS key',
            'verification_code' => 'SMS code',
        ];
    }
}
