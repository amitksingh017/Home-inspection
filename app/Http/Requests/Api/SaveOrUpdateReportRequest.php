<?php

namespace App\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class SaveOrUpdateReportRequest extends FormRequest
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
            'date'      => ['required', 'date'],
            'code'      => ['required', 'string', 'min:1', 'max:50'],
            'address'   => ['required', 'string', 'min:1', 'max:250']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'date' => Carbon::parse($this->date)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'),
            'code' => $this->id ?? null,
        ]);
    }
}
