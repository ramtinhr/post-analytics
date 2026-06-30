<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function paginate()
    {
        return Post::query()
            ->with('user')
            ->withCount('views')
            ->latest()
            ->paginate(15);
    }


    public function create(
        array $data,
        User $user
    ): Post {

        if (isset($data['image'])) {
            $data['image'] =
                $data['image']
                    ->store('posts', 'public');
        }


        return $user
            ->posts()
            ->create($data);
    }


    public function find(
        Post $post
    ): Post {

        return $post->load('user');
    }

    public function update(
        Post $post,
        array $data
    ): Post {

        if (isset($data['image'])) {

            if ($post->image) {
                Storage::disk('public')
                    ->delete($post->image);
            }

            $data['image'] =
                $data['image']
                    ->store('posts','public');
        }


        $post->update($data);

        return $post->refresh();
    }


    public function delete(
        Post $post
    ): bool {

        if ($post->image) {
            Storage::disk('public')
                ->delete($post->image);
        }


        return $post->delete();
    }
}
