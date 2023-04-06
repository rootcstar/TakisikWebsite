<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EncToDecRuleForInt implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $dec_value = fiki_decrypt($value);

        if(is_int($dec_value)){
            return true;
        }

        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Üyelik türünüzü doğru seçtiğinizden emin olunuz.';
    }
}
