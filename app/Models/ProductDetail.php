<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
