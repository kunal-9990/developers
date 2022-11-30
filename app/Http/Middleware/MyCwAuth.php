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

            if (!$request->session()->exists('targetUrl') && request()->path() !== 'documentation_files/login/undefined/OnlineOutput.xml') {
                $request->session()->put('targetUrl', "/".request()->path()); 
            }
            return redirect('/login');
        }
        else{
            return $next($request);
        }

    }
}
