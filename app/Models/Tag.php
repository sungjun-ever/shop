<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function productTags(): HasMany
    {
        return $this->hasMany(ProductTag::class, 'tag_id', 'id');
    }
}
