<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBillingAddress extends Model
{

    use HasFactory;
    protected $table = 'user_billing_addresses';

    protected $primaryKey = 'record_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['user_id', 'billing_address_line_1', 'billing_address_line_2', 'city', 'zip','country'];
}
