<?php

namespace App\Models;

use App\Enum\ProductStatus;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'full_description',
        'brand_id',
        'seller_id',
        'status',
    ];

    protected $table = 'products';

    protected $casts = [
        'status' => ProductStatus::class,
    ];
}
