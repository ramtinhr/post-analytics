<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_register(): void
    {
        $response = $this->postJson(
            '/api/register',
            [
                'name' => 'علی محمدی',

                'email' =>
                    'ali@example.com',

                'password' =>
                    'password123',

                'password_confirmation' =>
                    'password123',
            ]
        );


        $response->assertStatus(201);


        $this->assertDatabaseHas(
            'users',
            [
                'email'=>'ali@example.com'
            ]
        );


        $this->assertNotNull(
            $response['data']['token']
        );
    }



    public function test_duplicate_email_failed(): void
    {

        User::factory()->create([
            'email'=>'test@example.com'
        ]);


        $response = $this->postJson(
            '/api/register',
            [
                'name'=>'Test',

                'email'=>'test@example.com',

                'password'=>'password123',

                'password_confirmation'=>'password123',
            ]
        );


        $response
            ->assertStatus(422);

    }




    public function test_user_can_login(): void
    {

        $user =
            User::factory()->create([
                'password'=>
                    bcrypt('password123')
            ]);


        $response =
            $this->postJson(
                '/api/login',
                [
                    'email'=>$user->email,

                    'password'=>'password123',
                ]
            );


        $response
            ->assertStatus(200);


        $this->assertNotNull(
            $response['data']['token']
        );
    }



    public function test_invalid_login_failed(): void
    {

        $response =
            $this->postJson(
                '/api/login',
                [
                    'email'=>'fake@test.com',

                    'password'=>'wrong',
                ]
            );


        $response->assertStatus(401);

    }
}
