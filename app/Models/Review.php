<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'title',
        'content',
        'created_at',
        'updated_at',
        'verified_purchase',
        'helpful_votes',
    ];
}
