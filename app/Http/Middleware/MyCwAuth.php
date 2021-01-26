<?php

namespace App\Http\Middleware;

use Closure;
use session;
use Illuminate\Support\Facades\Cookie;

class MyCwAuth
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
        $authenticated = (is_null($request->session()->get('authenticated'))) ? false : true;

        if(!$authenticated) {
            Cookie::queue('targetUrl', url()->current(), 360);
            return redirect('/login');
        }
        else{
            return $next($request);
        }

    }
}
