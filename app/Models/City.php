<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use HasFactory;
    protected $table = "city";
    protected $primaryKey = 'city_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_updated';

    protected $fillable = ['license_plate_number', 'city_name_uppercase','city_name','city_name_lowercase'];
}
