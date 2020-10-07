<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please fill the name',
            'email.required' => 'Please fill the email',
            'password.required' => 'Please fill the password',
            'role_id.required' => 'Please Select the Role',
        ];
    }
}
