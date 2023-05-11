<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $user_id
 * @property integer $account_type
 * @property string $company_name
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $country_code
 * @property string $phone
 * @property string $password
 * @property boolean $is_confirmed
 * @property string $created_date
 * @property string $last_updated_date
 */
class User extends Model
{
    public static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            $model->password    = fiki_encrypt($model->password );
            $model->account_type = 2;

        });
        self::updating(function ($model) {
            $model->password    = fiki_encrypt($model->password );

        });
    }

    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';
    protected $fillable = ['account_type','company_name','first_name', 'last_name','email', 'country_code', 'phone', 'password','is_confirmed'];
}
