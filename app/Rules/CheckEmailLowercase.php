<?php

namespace App\Rules;

use App\Models\Inspector;
use Illuminate\Contracts\Validation\Rule;

class CheckEmailLowercase implements Rule
{
    protected $currentModelId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model_id)
    {
        $this->currentModelId = $model_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $modelIdArray = Inspector::query()->where('email', 'like', $value)->pluck('id')->toArray();

        if (!empty($modelIdArray)){
            if (in_array($this->currentModelId, $modelIdArray)){
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email has already been taken.';
    }
}
