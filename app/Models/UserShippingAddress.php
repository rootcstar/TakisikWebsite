<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShippingAddress extends Model
{
    use HasFactory;
    protected $table = 'user_shipping_addresses';

    protected $primaryKey = 'record_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['user_id', 'address_line_1', 'address_line_2', 'city', 'zip','country'];
}
