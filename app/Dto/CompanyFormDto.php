<?php

namespace App\Dto;

class CompanyFormDto
{
    public function __construct(
        public string $name,
        public string $description,
        public ?string $logo
    ) {
    }
}
