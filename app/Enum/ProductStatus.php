<?php

namespace App\Enum;

enum ProductStatus: string
{
    case ACTIVE = 'ACTIVE';
    case OUT_OF_STOCK = 'OUT_OF_STOCK';
    case DELETED = 'DELETED';
}