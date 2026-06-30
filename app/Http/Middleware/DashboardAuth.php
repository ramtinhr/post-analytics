<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class DashboardAuth
{

    public function handle(
        Request $request,
        Closure $next
    ): Response {


        if (!auth()->check()) {

            abort(401);

        }

        return $next($request);

    }

}
