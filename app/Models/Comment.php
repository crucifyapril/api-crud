<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'content',
        'rating',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
