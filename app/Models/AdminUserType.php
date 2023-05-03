<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $admin_user_type_id
 * @property string $admin_user_type_name
 * @property string $created_date
 * @property string $last_updated_date
 */
class AdminUserType extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    use HasFactory;
    protected $table = 'admin_user_types';
    protected $primaryKey = 'admin_user_type_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';
    protected $fillable = ['admin_user_type_name'];
}
