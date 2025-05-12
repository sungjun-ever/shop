<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'product_options';

    protected $fillable = [
        'option_group_id',
        'name',
        'additional_price',
        'sku',
        'stock',
        'display_order',
    ];
}
