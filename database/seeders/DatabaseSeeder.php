<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);


        $users =
            User::factory(10)
            ->create();


        $posts =
            Post::factory(50)
            ->create([
                'user_id' =>
                    $users->random()->id
            ]);


        PostView::factory(5000)
            ->create([
                'post_id' =>
                    $posts->random()->id
            ]);
    }
}
