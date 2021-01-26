<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|between:3,25|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/|unique:users,name',
                    'password' => 'required|string|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                $userId = auth('api')->id();

                return [
                    'name' => 'between:3,25|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/|unique:users,name,' .$userId,
                    'email'=>'email|unique:users,email,'.$userId,
                    'introduction' => 'max:80',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'verification_key' => 'SMS key',
            'verification_code' => 'SMS code',
        ];
    }
}
