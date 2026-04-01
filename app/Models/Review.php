<?php

namespace App\Models;

class Review
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public int $rating,
        public int $userId,
        public bool $isPinned = false
    ) {
    }
}
