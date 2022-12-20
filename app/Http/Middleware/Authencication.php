<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authencication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    protected function isLogin()
    {
        $isLogin = auth()->user();
        return is_null($isLogin);
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->isLogin()) {
            return response()->json(
                [
                    'status' => 403,
                    'err' => true,
                    'msg' => 'Bạn chưa đăng nhập',
                    'data' => [],
                ], 403
            );
        } else {
            return $next($request);
        }

    }
}
