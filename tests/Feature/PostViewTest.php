<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostViewTest extends TestCase
{
    use RefreshDatabase;



    public function test_post_view_is_registered(): void
    {

        $post =
            Post::factory()
                ->create();


       $response = $this->getJson(
    "/api/posts/{$post->id}"
);

$response->dump();


        $this->assertDatabaseCount(
            'post_views',
            1
        );

    }




    public function test_duplicate_view_same_day_not_registered(): void
    {

        $post =
            Post::factory()
                ->create();


        $this->getJson(
            "/api/posts/{$post->id}"
        );


       $response = $this->getJson(
            "/api/posts/{$post->id}"
        );

        $response->dump();


        $this->assertDatabaseCount(
            'post_views',
            1
        );
    }




    public function test_authenticated_user_gets_token(): void
    {

        $user =
            User::factory()->create();


        $response =
            $this
            ->actingAs(
                $user,
                'sanctum'
            )
            ->getJson(
                '/api/user'
            );


        $response
            ->assertStatus(200);

    }
}
