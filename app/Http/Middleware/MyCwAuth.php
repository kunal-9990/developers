<?php

namespace App\Http\Middleware;
use \Firebase\JWT\JWT;
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
        $authToken = $request->session()->get('authenticated');
        $decoded = (isset($authToken)) ? JWT::decode($authToken, env('AUTH_SECRET'), array('HS256')) : null;

        $authenticated = (is_null($decoded)) ? false : true;

        if(!$authenticated) {
            Cookie::queue('targetUrl', url()->current(), 5);
            return redirect('/login');
        }
        else{
            return $next($request);
        }

    }
}
