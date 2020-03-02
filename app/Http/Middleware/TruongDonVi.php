<?php

namespace App\Http\Middleware;
use App\Http\Controllers\UserController;

use Closure;
use Auth;

class TruongDonVi
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
        if(Auth::check())
        {
            if(UserController::isGroupNoneId((env('GROUP_TRUONGDONVI'))))
                return $next($request);
        }
        return redirect()->route('index');
    }
}
