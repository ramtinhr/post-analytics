<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostViewFactory extends Factory
{
    public function definition(): array
    {
        return [

            'post_id' =>
                Post::factory(),


            'user_id' =>
                fake()->boolean(70)
                ? User::factory()
                : null,


            'ip_address' =>
                fake()->ipv4(),


            'user_agent' =>
                fake()->userAgent(),


            'visitor_hash' =>
                hash(
                    'sha256',
                    Str::random(40)
                ),


            'view_date' =>
                fake()
                ->dateTimeBetween(
                    '-30 days',
                    'now'
                )
                ->format('Y-m-d'),


            'viewed_at' =>
                fake()
                ->dateTimeBetween(
                    '-30 days',
                    'now'
                ),
        ];
    }
}
