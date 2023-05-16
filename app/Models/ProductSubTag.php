<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $record_id
 * @property integer $product_id
 * @property integer $sub_tag_id
 * @property string $created_date
 * @property string $last_updated
 */
class ProductSubTag extends Model
{

    use HasFactory;

    protected $table = 'product_sub_tags';

    protected $primaryKey = 'record_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['product_id','sub_tag_id'];
}
