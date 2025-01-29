<?php

namespace App\Dto;

class UserFormDto
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $phone,
        public ?string $avatar
    ) {
    }
}
