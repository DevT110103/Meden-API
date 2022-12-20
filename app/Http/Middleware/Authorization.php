<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->bearerToken();

        $auth = auth()->user();
        if ($auth->role_id == 1) {
            return $next($request);
        }
        return response()->json([
            'status' => 403,
            'err' => true,
            'msg' => 'Authorization',
            'data' => [],
        ], 403);

    }
}
