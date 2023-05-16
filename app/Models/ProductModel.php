<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $record_id
 * @property integer $product_id
 * @property integer $model_number
 * @property string $created_date
 * @property string $last_updated
 */
class ProductModel extends Model
{

    use HasFactory;

    protected $table = 'product_models';

    protected $primaryKey = 'record_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['product_id','model_number'];
}

