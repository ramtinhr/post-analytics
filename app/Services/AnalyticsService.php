<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function daily(
        Post $post,
        ?string $from,
        ?string $to
    ) {

        return $post
            ->views()
            ->selectRaw(
                "
                DATE(viewed_at) as date,
                COUNT(*) as total_views,
                COUNT(DISTINCT visitor_hash) as unique_users,
                COUNT(user_id) as registered_users,
                COUNT(*) - COUNT(user_id) as guest_users
                "
            )
            ->when(
                $from,
                fn($q) =>
                    $q->whereDate(
                        'viewed_at',
                        '>=',
                        $from
                    )
            )
            ->when(
                $to,
                fn($q) =>
                    $q->whereDate(
                        'viewed_at',
                        '<=',
                        $to
                    )
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }


    public function summary(
        Post $post,
        ?string $from = null,
        ?string $to = null
    ) {

        $daily = $this->daily(
            $post,
            $from,
            $to
        );


        $totalViews = $daily
            ->sum('total_views');


        $uniqueUsers = $post
            ->views()
            ->when(
                $from,
                fn($q) =>
                    $q->whereDate(
                        'viewed_at',
                        '>=',
                        $from
                    )
            )
            ->when(
                $to,
                fn($q) =>
                    $q->whereDate(
                        'viewed_at',
                        '<=',
                        $to
                    )
            )
            ->distinct('visitor_hash')
            ->count('visitor_hash');


        $peak = $daily
            ->sortByDesc('unique_users')
            ->first();


        return [
            'post_id' => $post->id,

            'title' => $post->title,

            'period' => [
                'from' => $from,
                'to' => $to,
            ],

            'analytics' => $daily,

            'meta' => [

                'total_days' =>
                    $daily->count(),

                'total_unique_users' =>
                    $uniqueUsers,

                'total_views' =>
                    $totalViews,

                'average_daily_users' =>
                    round(
                        $uniqueUsers /
                        max($daily->count(),1),
                        2
                    ),

                'peak_day' =>
                    $peak?->date,

                'peak_users' =>
                    $peak?->unique_users,

                ...$this->trend(
                    $post,
                    $from,
                    $to
                )
            ]
        ];
    }


    private function trend(
        Post $post,
        ?string $from,
        ?string $to
    ): array {

        if (!$from || !$to) {

            return [
                'trend'=>'stable',
                'trend_percentage'=>0
            ];
        }


        $days =
            now()
            ->parse($from)
            ->diffInDays(
                now()->parse($to)
            ) + 1;


        $previousFrom =
            now()
            ->parse($from)
            ->subDays($days);


        $previousTo =
            now()
            ->parse($from)
            ->subDay();


        $current =
            $post->views()
            ->whereBetween(
                'viewed_at',
                [
                    $from,
                    $to
                ]
            )
            ->count();


        $previous =
            $post->views()
            ->whereBetween(
                'viewed_at',
                [
                    $previousFrom,
                    $previousTo
                ]
            )
            ->count();


        if ($previous == 0) {

            return [
                'trend'=>'upward',
                'trend_percentage'=>100
            ];
        }


        $percent =
            (($current - $previous)
            / $previous) * 100;


        return [

            'trend' =>
                $percent > 0
                ? 'upward'
                : (
                    $percent < 0
                    ? 'downward'
                    : 'stable'
                ),

            'trend_percentage' =>
                round($percent,2)
        ];
    }


    public function topViewed(
        int $limit = 10
    ) {

        return Post::query()
            ->with('user')
            ->withCount('views')
            ->withCount([
                'views as unique_users_count'
                => function ($query) {
                    $query->distinct(
                        'visitor_hash'
                    );
                }
            ])
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get()
            ->map(
                function($post,$index){

                return [
                    'rank'=>$index+1,

                    'post_id'=>$post->id,

                    'title'=>$post->title,

                    'author'=>$post
                        ->user
                        ->name,

                    'total_views'=>
                        $post->views_count,

                    'unique_users'=>
                        $post
                        ->unique_users_count,

                    'created_at'=>
                        $post->created_at,
                ];
            });
    }
}
