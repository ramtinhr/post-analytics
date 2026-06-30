<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Responses\ApiResponse;
use App\Models\Post;
use App\Services\PostService;
use App\Support\Messages;
use Illuminate\Http\Request;
use App\Services\ViewTrackerService;

class PostController extends Controller
{
    public function __construct(
        private PostService $service,
        private ViewTrackerService $tracker
    ) {}


    public function index()
    {
        return ApiResponse::success(
            PostResource::collection(
                $this->service->paginate()
            )
        );
    }


    public function store(StorePostRequest $request)
    {
        $post = $this->service->create(
            $request->validated(),
            $request->user()
        );

        return ApiResponse::success(
            new PostResource($post),
            Messages::CREATED,
            201
        );
    }


public function show(
    Request $request,
    Post $post,
        ViewTrackerService $tracker
    ) {
        $tracker->track(
            $post,
            $request
        );


        return ApiResponse::success(
            new PostResource($post)
        );
    }

    public function destroy(
    Post $post
    ) {

        $this->service->delete($post);

        return ApiResponse::success(
            null,
            Messages::DELETED
        );
    }
}
