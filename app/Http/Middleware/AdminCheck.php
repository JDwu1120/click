<?php

namespace App\Http\Middleware;

use App\dto\feedback;
use App\dto\Operate;
use App\Service\Imploment\AdminService;
use Closure;

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
        $email = $request->input('email');
        $admin = new AdminService();
        if ($admin->adminCheck($email)){
            return $next($request);
        }else{
            return new feedback(false,'您不是管理员');
        }
    }
}
