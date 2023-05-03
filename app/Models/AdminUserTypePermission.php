<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $record_id
 * @property integer $admin_user_type_id
 * @property integer $permission_id
 * @property string $created_date
 * @property string $last_updated
 */
class AdminUserTypePermission extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */


    use HasFactory;
    protected $table = 'admin_user_type_permissions';

    protected $primaryKey = 'record_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';
    protected $fillable = ['admin_user_type_id', 'permission_id'];
}
