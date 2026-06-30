<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ViewTrackerService
{
    public function track(
        Post $post,
        Request $request
    ): PostView {

        $hash = $this->visitorHash($request);


        return PostView::firstOrCreate(

            [
                'post_id' => $post->id,

                'visitor_hash' => $hash,

                'view_date' => now()->toDateString(),
            ],

            [
                'user_id' => auth()->id(),

                'ip_address' => $request->ip(),

                'user_agent' => $request->userAgent(),

                'viewed_at' => now(),
            ]
        );
    }


    private function visitorHash(
        Request $request
    ): string {

        if (auth()->check()) {

            return hash(
                'sha256',
                'user:' . auth()->id()
            );
        }


        return hash(
            'sha256',
            $request->ip()
            . '|'
            . $request->userAgent()
        );
    }
}
