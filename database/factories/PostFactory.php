<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'title' =>
                fake()->sentence(5),

            'content' =>
                fake()->paragraphs(3, true),

            'image' => null,
        ];
    }
}
