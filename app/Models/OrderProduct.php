<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    use HasFactory;
    protected $table = "order_products";
    protected $primaryKey = 'record_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['order_id', 'model_record_id','product_id','	product_name','quantitiy','wholesale_price','user_discount_percentage','total_price','order_status'];
}
