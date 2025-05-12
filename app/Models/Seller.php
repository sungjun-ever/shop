<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
