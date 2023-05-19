<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $model_record_id
 * @property integer image_record_id
 * @property integer $product_id
 * @property integer $product_image
 * @property integer $model_number
 */
class ProductModelAndImage extends Model
{
    use HasFactory;

    protected $table = 'v_products_models_and_images';



    /**
     * @var array
     */
    protected $fillable = ['model_record_id','image_record_id',
                            'product_id','product_code',
                        'model_number','product_image'];
}
