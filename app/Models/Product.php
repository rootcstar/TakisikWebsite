<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $product_id
 * @property string $barcode
 * @property string $product_code
 * @property string $product_name
 * @property integer $unit_qty
 * @property integer $unit_id
 * @property integer $main_unit_qty
 * @property integer $main_unit_id
 * @property double $single_price
 * @property double $wholesale_price
 * @property double $retail_price
 * @property integer $kdv
 * @property boolean $is_active
 * @property boolean $is_new
 * @property string $created_date
 * @property string $last_updated
 */
class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $primaryKey = 'product_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['barcode', 'product_code', 'product_name',
                            'unit_qty', 'unit_id',
                            'main_unit_qty', 'main_unit_id',
                            'single_price', 'wholesale_price', 'retail_price',
                            'kdv', 'is_active', 'is_new'];
}
