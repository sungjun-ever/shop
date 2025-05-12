<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = [
        'product_id',
        'url',
        'alt_text',
        'is_primary',
        'display_order',
        'option_id',
    ];
}
