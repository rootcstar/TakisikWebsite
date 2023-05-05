<?php

namespace App\Rules;

use App\Models\PermissionType;
use Illuminate\Contracts\Validation\Rule;

class CheckIfPermissionTypeExists implements Rule
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
        $count = PermissionType::where('permission_id', $value)->count();
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
        return 'This permission type does not exists.';
    }
}
