<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


/**
 * @property integer $sub_tag_id
 * @property string $sub_tag_name
 * @property string $display_name
 * @property integer $display_order
 * @property boolean $is_active
 * @property string $url_name
 * @property string $created_date
 * @property string $last_updated
 */
class SubTag extends Model
{
    public static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            $model->url_name    = Str::slug($model->display_name,'');

        });
    }
    use HasFactory;
    protected $table = 'sub_tags';

    protected $primaryKey = 'sub_tag_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    /**
     * @var array
     */
    protected $fillable = ['sub_tag_name', 'display_name', 'display_order', 'is_active', 'url_name'];
}
