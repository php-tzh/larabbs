<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
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
        if($request->user()
            && !$request->user()->hasVerifiedEmail()
            && !$request->is('email/*','logout')){
            //根据客户端返回对应内容
                //判断是否是json请求，如果是走abort
            return $request->expectsJson()
                        ?abort(403,'Your email address is not verified.')
                        :redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
