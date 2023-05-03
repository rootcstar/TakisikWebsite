<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $admin_id
 * @property string $first_name
 * @property string $last_name
 * @property string $title
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property integer $admin_user_type_id
 * @property boolean $is_active
 * @property string $created_date
 * @property string $last_updated_date
 */
class AdminUser extends Model
{
    public static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            $model->password    = fiki_encrypt($model->password);

        });
    }
    use HasFactory;
    protected $table = 'admin_users';
    protected $primaryKey = 'admin_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';
    protected $fillable = ['first_name', 'last_name','title', 'email', 'phone', 'password', 'admin_user_type_id','is_active'];

}
