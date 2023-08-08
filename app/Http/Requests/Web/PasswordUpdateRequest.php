<?php

namespace App\Http\Requests\Web;


use Illuminate\Foundation\Http\FormRequest;


class PasswordUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'current_password' => [
                'required',
                'min:6',
                'max:26'
            ],
            'password' => [
                'required',
                'min:6',
                'max:26',
                'regex:/^.*(?=.*[A-Z])(?=.*[0-9]).*$/',
                'confirmed'
            ],
        ];
    }
}
