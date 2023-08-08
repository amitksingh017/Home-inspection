<?php

namespace App\Http\Requests\Web;


use App\Rules\PhoneLengthRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class AdminUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,'. \Auth::user()->id
            ],
            'first_name' => ['required', 'string',  'min:2', 'max:255'],
            'last_name' => ['required', 'string',  'min:2', 'max:255'],
        ];
    }
}
