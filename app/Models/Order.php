<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    protected $table = "orders";
    protected $primaryKey = 'order_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['user_id', 'order_status_id','amount','is_discount_used','discount_percentage','shipping_address_id','billing_same_as_shipping','billing_address_id','note'];
}
