<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOptionGroup extends Model
{
    protected $table = 'product_option_groups';

    protected $fillable = [
        'product_id',
        'name',
        'display_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'option_group_id', 'id');
    }
}
