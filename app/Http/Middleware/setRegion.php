<?php

namespace App\Http\Middleware;

use Closure;
use Unirest\Request as Unirest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;



class setRegion
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
        $regionCookieSet = (is_null(Cookie::get('region'))) ? false : true;
        $requestRegion;
        $regionSlug = (!empty($request->segments()[0])) ? $request->segments()[0] : '';
        $response;
        if(!$regionCookieSet) {

            $ip = $request->ip();

            if($ip == '127.0.0.1' || $ip == '192.168.207.56'){
                $ip = '66.207.217.22';
            }
            $method = 'http://api.ipstack.com/'.$ip.'?access_key='.env("IP_STACK_KEY");
            $response = Unirest::get($method);

            //adding log
            Log::info('Ipstack called from setRegion middleware and IP is: '. $ip);
          
            $requestRegion = isset($response->body->country_code) ? strtolower($response->body->country_code) : 'int';
            if ($requestRegion !== 'ca' && $requestRegion !== 'us') {
                $requestRegion = 'int';
            }
            //set region cookie according to geolocation
            Cookie::queue('region', strtolower($requestRegion), 60*24*365);
            // Log::info("Log response:".var_dump($response));
        }
        
        if(!isset($requestRegion)){
            $requestRegion = Cookie::get('region');
        } 

        // show lightbox if geolocation doesn't match region url parameter
        if(strtolower($regionSlug) !== $requestRegion){
            
            $request->session()->flash('openRegionLightbox', true);
            $request->session()->flash('requestRegion', $requestRegion);
        }
        else{
            $request->session()->flash('openRegionLightbox', false);
        }

        return $next($request);
    }
}
