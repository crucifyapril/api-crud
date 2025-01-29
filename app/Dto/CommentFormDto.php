<?php

namespace App\Dto;

class CommentFormDto
{
    public function __construct(
        public int $commentable_id,
        public string $commentable_type,
        public string $content,
        public int $rating
    ) {
    }
}
