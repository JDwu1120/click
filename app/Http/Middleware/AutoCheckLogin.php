<?php

namespace App\Http\Middleware;

use App\Service\Imploment\LoginService;
use Closure;

class AutoCheckLogin
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
//        $token = $request->input('token');
//        $user = new LoginService();
//        if ($user->checkLog($token)){
            return $next($request);
//        }
//        exit('清先登录');
    }
}
