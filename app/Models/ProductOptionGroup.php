<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionGroup extends Model
{
    protected $table = 'product_option_groups';

    protected $fillable = [
        'product_id',
        'name',
        'display_order',
    ];
}
