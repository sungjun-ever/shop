<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends Model
{
    protected $table = 'sellers';

    protected $fillable = [
        'name',
        'description',
        'logo_url',
        'rating',
        'contact_email',
        'contact_phone',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }
}
