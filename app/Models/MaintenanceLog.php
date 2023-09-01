<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $record_id
 * @property string $log_type
 * @property string $data
 * @property string $created_date
 * @property string $last_updated
 * @property boolean $is_solved
 * @property string $solved_date
 * @property string $comment
 */
class MaintenanceLog extends Model
{

    use HasFactory;
    protected $table = "maintenance_logs";
    protected $primaryKey = 'record_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['log_type', 'data'];
}
