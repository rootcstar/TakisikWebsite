<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{

    use HasFactory;
    protected $table = "district";
    protected $primaryKey = 'district_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['city_id', 'district_name_uppercase','district_name','district_name_lowercase'];
}
