<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyticsRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Post;
use App\Services\AnalyticsService;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsService $service
    ) {}


    public function daily(
        AnalyticsRequest $request,
        Post $post
    ) {

        return ApiResponse::success(
            $this->service->daily(
                $post,
                $request->from,
                $request->to
            )
        );
    }


    public function summary(
        AnalyticsRequest $request,
        Post $post
    ) {

        return ApiResponse::success(
            $this->service->summary(
                $post,
                $request->from,
                $request->to
            )
        );
    }


    public function topViewed()
    {
        return ApiResponse::success(
            $this->service->topViewed()
        );
    }
}
