<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property integer $record_id
 * @property integer $product_id
 * @property string $product_image
 * @property integer $model_number
 * @property boolean $is_default
 * @property string $created_date
 * @property string $last_updated
 */
class ProductImage extends Model
{
    public static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            $model->is_default    = 1;

        });
        self::updating(function ($model) {
            $model->is_default    = 1;

        });
    }

    use HasFactory;

    protected $table = 'product_images';

    protected $primaryKey = 'record_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['product_id','product_image','model_number','is_default'];
}
