<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $unit_id
 * @property string $unit_name
 * @property string $created_date
 * @property string $last_updated
 */
class Unit extends Model
{
    use HasFactory;
    protected $table = 'units';

    protected $primaryKey = 'unit_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['unit_name'];
}
