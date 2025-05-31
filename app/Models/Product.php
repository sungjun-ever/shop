<?php

namespace App\Models;

use App\Enum\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    public function productTags(): HasMany
    {
        return $this->hasMany(ProductTag::class, 'product_id', 'id');
    }

    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function productOptionGroups(): HasMany
    {
        return $this->hasMany(ProductOptionGroup::class, 'product_id', 'id');
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function reviewStats(): HasOne
    {
        return $this->hasOne(Review::class)
            ->selectRaw('product_id, AVG(rating) as avg_rating, COUNT(rating) as review_count')
            ->groupBy('product_id');
    }

    public function reviewRatingDistribution(): HasMany
    {
        return $this->hasMany(Review::class)
            ->selectRaw('product_id, rating, COUNT(rating) as count')
            ->groupBy('product_id', 'rating');
    }

    public function productPrice(): HasOne
    {
        return $this->hasOne(ProductPrice::class, 'product_id', 'id');
    }

    public function productDetail(): HasOne
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }
}
