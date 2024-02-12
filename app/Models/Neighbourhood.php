<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighbourhood extends Model
{
    use HasFactory;
    protected $table = "neighbourhood";
    protected $primaryKey = 'neighbourhood_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['city_id', 'district_id','neighbourhood_name_uppercase','neighbourhood_name','neighbourhood_name_lowercase'];
}
