<?php

namespace App\Rules;

use App\Models\AdminUserType;
use Illuminate\Contracts\Validation\Rule;


class CheckIfAdminUserTypeExists implements Rule
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
        $count = AdminUserType::where('admin_user_type_id', $value)->count();
        if($count == 0){
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
        return 'This admin user type does not exists.';
    }
}
