<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AnalyticsController extends Controller
{

    public function index(Request $request)
    {

        $from = $request->from
            ?? now()->subDays(30)->toDateString();


        $to = $request->to
            ?? now()->toDateString();



        $daily = PostView::query()

            ->select(
                DB::raw('DATE(viewed_at) as date'),
                DB::raw('COUNT(*) as total_views'),
                DB::raw('COUNT(DISTINCT user_id) as unique_users')
            )

            ->whereBetween(
                'viewed_at',
                [
                    $from.' 00:00:00',
                    $to.' 23:59:59'
                ]
            )

            ->groupBy(
                DB::raw('DATE(viewed_at)')
            )

            ->orderBy('date')

            ->get();



        $topPosts = Post::query()

            ->withCount('views')

            ->orderByDesc('views_count')

            ->limit(5)

            ->get();



        return view(
            'analytics.index',
            compact(
                'daily',
                'topPosts',
                'from',
                'to'
            )
        );

    }

}
