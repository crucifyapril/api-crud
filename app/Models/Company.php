<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    protected $fillable = [
      'name',
      'description',
      'logo',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
