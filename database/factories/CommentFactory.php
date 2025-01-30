<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'commentable_id' => Company::query()->inRandomOrder()->first()->id,
            'commentable_type' => 'Company',
            'content' => $this->faker->text(400),
            'rating' => $this->faker->numberBetween(1, 10),
        ];
    }
}
