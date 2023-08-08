<?php


namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:inspectors',
            'token' => 'required|string',
            'password' => '
                required|
                min:6|
                string|
                regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9]).*$/|
                confirmed'
        ];
    }
}