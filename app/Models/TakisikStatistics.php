<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $record_id
 * @property string $event_name
 * @property mixed $data
 * @property int $requester_id
 * @property string $created_date
 * @property string $last_updated
 * @property string $requester_type
 * @property string $requester_ip
 * @property string $country
 * @property string $region
 * @property string $city
 */
class TakisikStatistics extends Model
{
    use HasFactory;

    protected $table = 'takisik_statistics';
    protected $primaryKey = 'record_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['event_name', 'data', 'requester_id','requester_type','requester_ip','region','city','country'];
}
