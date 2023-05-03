<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $permission_id
 * @property string $permission_name
 * @property string $permission_code
 * @property string $created_date
 * @property string $last_updated
 */
class PermissionType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use HasFactory;
    protected $table = 'permission_types';

    protected $primaryKey = 'permission_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['permission_name', 'permission_code'];
}
