<?php

namespace App\DTO\Tag;

class CreateTagDTO
{

    public function __construct(
        public string $name,
        public string $slug,
    )
    {
    }
}