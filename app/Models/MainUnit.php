<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $main_unit_id
 * @property string $main_unit_name
 * @property string $created_date
 * @property string $last_updated
 */
class MainUnit extends Model
{

    public static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            $model->main_unit_name    = strtoupper($model->main_unit_name );

        });
        self::updating(function ($model) {
            $model->main_unit_name    = strtoupper($model->main_unit_name );

        });

    }
    use HasFactory;
    protected $table = 'main_units';

    protected $primaryKey = 'main_unit_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['main_unit_name'];
}
