<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function index(): View
    {

        $stats = [
            'total_views' => PostView::count(),

            'unique_users' => PostView::query()
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count('user_id'),

            'average_daily_users' =>
                round(
                    PostView::query()
                    ->select(
                        DB::raw(
                            'COUNT(DISTINCT user_id)'
                        )
                    )
                    ->groupBy(
                        DB::raw(
                            'DATE(viewed_at)'
                        )
                    )
                    ->get()
                    ->avg('0'),
                    2
                ),

            'posts' => Post::count(),
        ];



        $chart = $this->chartData();



        $topPosts = Post::query()
            ->withCount('views')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get()
            ->map(function ($post, $index) {

                return [
                    'rank' => $index + 1,
                    'title' => $post->title,
                    'total_views' => $post->views_count,
                    'unique_users' =>
                        $post->views()
                        ->distinct('user_id')
                        ->count('user_id'),
                ];

            });



        return view(
            'dashboard.index',
            compact(
                'stats',
                'chart',
                'topPosts'
            )
        );

    }



    private function chartData(): array
    {

        $data = PostView::query()
            ->select(
                DB::raw(
                    'DATE(viewed_at) as date'
                ),
                DB::raw(
                    'COUNT(*) as views'
                )
            )
            ->groupBy(
                DB::raw(
                    'DATE(viewed_at)'
                )
            )
            ->orderBy('date')
            ->get();



        return [
            'dates' =>
                $data->pluck('date'),

            'views' =>
                $data->pluck('views'),
        ];

    }

}
