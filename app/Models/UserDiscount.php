<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDiscount extends Model
{
    use HasFactory;
    protected $table = 'user_discounts';

    protected $primaryKey = 'record_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['user_id', 'discount_percentage', 'is_deleted'];
}
