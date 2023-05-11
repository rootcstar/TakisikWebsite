<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $record_id
 * @property integer $tag_id
 * @property integer $sub_tag_id
 * @property string $created_date
 * @property string $last_updated
 */
class TagToSubTag extends Model
{
    use HasFactory;
    protected $table = 'tag_to_sub_tags';

    protected $primaryKey = 'record_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['tag_id', 'sub_tag_id'];
}
