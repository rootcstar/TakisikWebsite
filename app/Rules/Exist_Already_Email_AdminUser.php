<?php

namespace App\Rules;

use App\Models\AdminUser;
use Illuminate\Contracts\Validation\Rule;

class Exist_Already_Email_AdminUser implements Rule
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
        $user_count  = AdminUser::where('email',$value)->where('is_active',true)->count();
        if($user_count == 0){
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
        return 'This email is already exists.';
    }
}
