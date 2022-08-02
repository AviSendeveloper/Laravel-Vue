<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || (Auth::User()->user_type === 'user')) {
            // return response()->json([
            //     'msg' => 'You are not authorised to access to this page'
            // ], 403);
            return redirect('/');
        };
        return $next($request);
    }
}
