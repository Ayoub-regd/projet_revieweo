<?php

namespace App\Models;

class User
{
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        public string $role
    ) {
    }
}
