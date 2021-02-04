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

        $authenticated = $request->session()->get('authenticated');

        if(!$authenticated) {

            if (!$request->session()->has('targetUrl')) {
                $request->session()->put('targetUrl', url()->current());               
            }
            return redirect('/login');
        }
        else{
            return $next($request);
        }

    }
}
