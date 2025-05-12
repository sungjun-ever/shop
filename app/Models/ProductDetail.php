<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_details';
    protected $fillable = [
        'product_id',
        'weight',
        'dimensions',
        'materials',
        'country_of_origin',
        'warranty_info',
        'care_instructions',
        'additional_info'
    ];
}
